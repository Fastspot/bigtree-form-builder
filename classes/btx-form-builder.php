<?
	/*
		Class: BTXFormBuilder
			Provides an interface for form builder data.
	*/

	class BTXFormBuilder extends BigTreeModule {
		var $Table = "btx_form_builder_forms";
		static $SearchPageCount = false;
		
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

			$fields = array();
			$object_count = 0;
			$field_query = sqlquery("SELECT * FROM btx_form_builder_fields WHERE form = '$id' AND `column` = '0' ORDER BY position DESC, id ASC");
			while ($field = sqlfetch($field_query)) {
				$object_count++;

				if ($field["type"] == "column") {
					// Get left column
					$column_fields = array();
					$column_query = sqlquery("SELECT * FROM btx_form_builder_fields WHERE `column` = '".$field["id"]."' AND `alignment` = 'left' ORDER BY position DESC, id ASC");
					while ($sub_field = sqlfetch($column_query)) {
						$column_fields[] = $sub_field;
						$object_count++;
					}
					$field["fields"] = $column_fields;
					$fields[] = $field;

					// Get right column
					$column_fields = array();
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
			return $mod->getMatching("form",$id,"id DESC");
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
			$mod = new BigTreeModule("btx_form_builder_entries");
			$results = $mod->search($query,"id DESC");
			
			$pages = ceil(count($results) / 15);
			self::$SearchPageCount = $pages ? $pages : 1;

			return array_slice($results,($page - 1) * 15,15);
		}
	}
?>
