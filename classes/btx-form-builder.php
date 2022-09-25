<?php
	/*
		Class: BTXFormBuilder
			Provides an interface for form builder data.
	*/
	
	class BTXFormBuilder extends BigTreeModule {
		
		public $Table = "btx_form_builder_forms";
		
		public static $SearchPageCount = false;
		
		/*
			Function: getForm
				Gets form information and related fields.

			Parameters:
				id - The form ID
			
			Returns:
				A form array or false if the form doesn't exist.
		*/
		
		static function getForm($id) {
			$id = sqlescape($id);
			$form = sqlfetch(sqlquery("SELECT * FROM btx_form_builder_forms WHERE id = '$id'"));
			
			if (!$form) {
				return false;
			}
			
			$fields = [];
			$object_count = 0;
			$field_query = sqlquery("SELECT * FROM btx_form_builder_fields WHERE form = '$id' AND `column` = '0' ORDER BY position DESC, id ASC");
			
			while ($field = sqlfetch($field_query)) {
				$object_count++;
				
				if ($field["type"] == "column") {
					// Get left column
					$column_fields = [];
					$column_query = sqlquery("SELECT * FROM btx_form_builder_fields WHERE `column` = '".$field["id"]."' AND `alignment` = 'left' ORDER BY position DESC, id ASC");
					
					while ($sub_field = sqlfetch($column_query)) {
						$column_fields[] = $sub_field;
						$object_count++;
					}
					
					$field["fields"] = $column_fields;
					$fields[] = $field;
					
					// Get right column
					$column_fields = [];
					$column_query = sqlquery("SELECT * FROM btx_form_builder_fields WHERE `column` = '".$field["id"]."' AND `alignment` = 'right' ORDER BY position DESC, id ASC");
					
					while ($sub_field = sqlfetch($column_query)) {
						$column_fields[] = $sub_field;
						$object_count++;
					}
					
					$field["fields"] = $column_fields;
					$fields[] = $field;
					
					// Column start/end count as objects so we add 3 since there's two columns
					$object_count += 3;
				} else {
					$fields[] = $field;
				}
			}
			
			$form["fields"] = $fields;
			$form["object_count"] = $object_count - 1; // We start at 0
			
			return $form;
		}
		
		/*
			Function: getAllForms
				Returns all forms (without fields).

			Parameters:
				sort - Sort order (defaults to id ASC)

			Returns:
				An array of form arrays.
		*/
		
		static function getAllForms($sort = "id ASC") {
			$mod = new BigTreeModule("btx_form_builder_forms");
			
			return $mod->getAll($sort);
		}
		
		/*
			Function: getEntries
				Returns a form's user entries, most recent first.

			Parameters:
				id - Form ID

			Returns:
				An array of entries arrays.
		*/
		
		static function getEntries($id) {
			$mod = new BigTreeModule("btx_form_builder_entries");
			
			return $mod->getMatching("form", $id, "id DESC");
		}
		
		/*
			Function: getEntry
				Returns a user entry.

			Parameters:
				id - Entry ID

			Returns:
				An array.
		*/
		
		static function getEntry($id) {
			$mod = new BigTreeModule("btx_form_builder_entries");
			
			return $mod->get($id);
		}
		
		/*
			Function: getField
				Returns a decoded field.

			Parameters:
				id - A field ID

			Returns:
				An array.
		*/
		
		static function getField($id) {
			$mod = new BigTreeModule("btx_form_builder_fields");
			
			return $mod->get($id);
		}
		
		/*
			Function: getFormUsage
				Returns an array of pages that use this form.

			Parameters:
				id - Form ID

			Returns:
				An array.
		*/
		
		static function getFormUsage($id) {
			$pages = [];
			$q = sqlquery("SELECT * FROM bigtree_pages WHERE template LIKE '%form-builder%' ORDER BY nav_title ASC");
			
			while ($page = sqlfetch($q)) {
				$page["resources"] = json_decode($page["resources"], true);
				
				if ((is_array($page["resources"]["form"]) && $page["resources"]["form"]["form"] == $id) ||
					$page["resources"]["form"] == $id) {
					$pages[] = $page;
				}
			}
			
			return $pages;
		}
		
		/*
			Function: hashCheck
				Checks to see if a recently submitted value to a form has the same hash.

			Parameters:
				form - Form ID to check against
				hash - The hash to check against

			Returns:
				boolean
		*/
		
		static function hashCheck($form, $hash) {
			$form = sqlescape($form);
			$hash = sqlescape($hash);
			$result = sqlfetch(sqlquery("SELECT id FROM btx_form_builder_entries 
										 WHERE form = '$form'
										   AND hash = '$hash'
										   AND created_at >= '".date("Y-m-d H:i:s", strtotime("-10 minutes"))."'"));
			
			return !empty($result);
		}
		
		/*
			Function: parseTokens
				Parses the token array for a field and modifies it (token_list is by reference).
			
			Parameters:
				token_list - An array of tokens (as keys) and values
				type - A field type
				label - The field label
				value - The value to store
				reset - Call if using a second data set to re-init duplicates array
		*/
		
		static function parseTokens(&$token_list, $type, $label, $value, $reset = false) {
			static $duplicates = [];
			
			if ($reset) {
				$duplicates = [];
				
				return false;
			}
			
			if ($type !== "columns" && $type !== "captcha" && $type !== "section") {
				if (isset($duplicates[$label])) {
					$duplicates[$label]++;
					$token_list[$label."--".$duplicates[$label]] = $value;
				} else {
					if (!isset($token_list[$label])) {
						$token_list[$label] = $value;
					} else {
						$duplicates[$label] = 2;
						
						$existing_value = $token_list[$label];
						unset($token_list[$label]);
						
						$token_list[$label."--1"] = $existing_value;
						$token_list[$label."--2"] = $value;
					}
				}
			}
		}
		
		/*
			Function: searchEntries
				Searches a form's entries and returns a page of 15 ordered by most recent first.
				Sets BTXFormBuilder::$SearchPageCount to the number of pages of results.

			Parameters:
				id - Form ID
				query - Search terms
				page - Page to return (beginning with 1 as first page)

			Returns:
				An array of entries.
		*/
		
		static function searchEntries($id,$query,$page = 1) {
			$total_string = "SELECT COUNT(*) FROM btx_form_builder_entries WHERE `form` = '".((int) $id)."'";
			$query_string = "SELECT * FROM btx_form_builder_entries WHERE `form` = '".((int) $id)."'";
			$query_parts = explode(" ", $query);
			
			foreach ($query_parts as $part) {
				$part = SQL::escape($part);
				$query_string .= " AND data LIKE '%$part%'";
				$total_string .= " AND data LIKE '%$part%'";
			}
			
			$query_string .= " ORDER BY id DESC LIMIT ".(($page - 1) * 15).", 15";
			
			$mod = new BigTreeModule("btx_form_builder_entries");
			$total = SQL::fetchSingle($total_string);
			$results = array_map([$mod, "get"], SQL::fetchAll($query_string));
			self::$SearchPageCount = ceil($total / 15) ?? 1;
			
			return $results;
		}
	}
