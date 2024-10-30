<?php

interface DatabasesAccess
{
	public function doesExerciseExist(int $id): bool;

	public function createExercise(string $title): int;

	public function getExerciseTitle(int $id): string;

	public function getExercises(int $status = -1): array;

	public function getFields(int $exercise_id): array;

	public function doesFieldExist(int $id): bool;

	public function doesFulfillmentExist(int $id): bool;

	public function getFulfillmentField(int $id): int;

	public function getFulfillmentBody(int $id): string;

	public function getFieldLabel(int $id): string;

	public function getFieldKind(int $id): int;

	public function createField(int $exercise_id, string $label, int $kind): int;

	public function deleteField(int $id): void;

	public function isFieldInExercise(int $exercise_id, int $field_id): bool;

	public function setFieldLabel(int $id, string $label): void;

	public function setFieldKind(int $id, int $kind): void;

	public function deleteExercise(int $id): void;

	public function getExerciseStatus(int $id): int;

	public function setExerciseStatus(int $id, int $status);

	public function getFieldsCount(int $exercise_id): int;
}
