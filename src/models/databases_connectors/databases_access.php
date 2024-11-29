<?php
/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description  Database acces implementation if we need to change the database just implement this class that will return the result of for example sql request
 */
define('ALL_EXERCISES', -1);

interface DatabasesAccess
{
	public function doesExerciseExist(int $id): bool;

	public function createExercise(string $title): int;

	public function getExerciseTitle(int $id): string;

	public function getExercises(int $status = ALL_EXERCISES): array;

	public function getFields(int $exercise_id): array;

	public function doesFieldExist(int $id): bool;

	public function doesFulfillmentExist(int $id): bool;

	public function getFulfillmentFields(int $id): array;

	public function getFulfillmentBody(int $field_id, int $fulfillment_id): string;

	public function getFulfillmentTimestamp(int $id);

	public function setFulfillmentBody(int $field_id, int $fulfillment_id, string $body): void;

	public function createFulfillment(int $exercise_id): int;

	public function getFulfillments(int $exercise_id);

	public function createFulfillmentField(int $field_id, int $fulfillment_id, string $body): void;

	public function getFieldLabel(int $id): string;

	public function getFieldKind(int $id): int;

	public function createField(int $exercise_id, string $label, int $kind): int;

	public function deleteField(int $id): void;

	public function isFieldInExercise(int $exercise_id, int $field_id): bool;

	public function isFulfillmentInExercise(int $exercise_id, int $fulfillment_id): bool;

	public function setFieldLabel(int $id, string $label): void;

	public function setFieldKind(int $id, int $kind): void;

	public function deleteExercise(int $id): void;

	public function getExerciseStatus(int $id): int;

	public function setExerciseStatus(int $id, int $status);

	public function getFieldsCount(int $exercise_id): int;

	public function getExerciseByFieldId(int $field_id): int;

	public function getExerciseByFulfillmentId(int $fulfillment_id): int;
}
