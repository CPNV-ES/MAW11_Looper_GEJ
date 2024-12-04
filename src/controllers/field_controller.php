<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description  This file is for the field controller without the View
 */

require_once MODEL_DIR . '/exercise.php';

/**
 * FieldController
 *
 * Handles backend logic for managing fields in exercises.
 */
class FieldController
{
	/**
	 * This method creates a new field within an existing exercise, using the label and value kind
     * provided by the user in `$_POST['field']`.
	 *
	 * @param int $exercise_id The ID of the exercise for which the field is being created.
	 * @return void
	 */
	public function createField(int $exercise_id)
	{
		if (!isset($_POST['field']['label'], $_POST['field']['value_kind'])) {
			badRequest();
			return;
		}

		$exercise = null;

		$exercise = new Exercise($exercise_id);

		$kind = $this->kindStringToKindEnum($_POST['field']['value_kind']);

		$exercise->createField($_POST['field']['label'], $kind);

		header('Location: /exercises/' . $exercise_id . '/fields');
	}

	/**
	 * This method deletes a field identified by `$field_id` from an exercise identified by `$exercise_id`.
	 *
	 * @param  int $exercise_id The ID of the exercise from which the field is to be deleted.
	 * @param  int $field_id The ID of the field that is to be deleted.
	 * @return void
	 */
	public function deleteField(int $exercise_id, int $field_id)
	{
		$exercise = null;

		$exercise = new Exercise($exercise_id);
		$field = new Field($field_id);

		if ($exercise->isFieldInExercise($field)) {
			$field->delete();
		}

		header('Location: /exercises/' . $exercise_id . '/fields');
	}

	/**
	 * This method allows the editing of an existing field for a given exercise.
	 *
	 * @param  int $exercise_id The ID of the exercise containing the field.
	 * @param  int $field_id The ID of the field to be edited.
	 * @return void
	 */
	public function editField(int $exercise_id, int $field_id)
	{
		$exercise = new Exercise($exercise_id);
		$field = new Field($field_id);

		if (!$exercise->isFieldInExercise($field)) {
			lost();
			return;
		}

		if (isset($_POST['field']['label'])) {
			$field->setLabel($_POST['field']['label']);
		}

		if (isset($_POST['field']['value_kind'])) {
			$field->setKind($this->kindStringToKindEnum($_POST['field']['value_kind']));
		}

		header('Location: /exercises/' . $exercise_id . '/fields/' . $field_id . '/edit');
	}

	/**
	 * This method converts a string representation of a field kind to the corresponding enumeration value.
     * It handles different kinds, such as `single_line_list`, `multi_line`, and `single_line`, and returns
     * the appropriate enumeration.
	 *
	 * @param  string $kind The kind of the field as a string.
	 * @return Kind The corresponding `Kind` enumeration value.
	 */
	private function kindStringToKindEnum(string $kind)
	{
		switch ($kind) {
			case 'single_line_list':
				return Kind::ListOfSingleLines;
			case 'multi_line':
				return Kind::MultiLineText;
			default:
			case 'single_line':
				return Kind::SingleLineText;
		}
	}
}
