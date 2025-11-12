<?php

namespace App\Pipelines\Filters;

use Illuminate\Database\Eloquent\Builder;

class SearchFilter extends BaseFilter
{
    protected string $parameter = 'search';

    /**
     * Fields to search across for different models
     */
    protected array $searchFields = [
        'tests' => ['title', 'description'],
        'chapters' => ['title', 'content'],
        'faqs' => ['question', 'answer'],
        'questions' => ['question', 'explanation'],
    ];

    /**
     * Apply search filter across multiple fields
     */
    protected function applyFilter(Builder $query, mixed $value): Builder
    {
        $searchTerm = trim($value);

        if (empty($searchTerm)) {
            return $query;
        }

        // Detect the model based on the query
        $modelClass = $query->getModel();
        $tableName = $modelClass->getTable();
        $fields = $this->getSearchFieldsForModel($tableName);

        if (empty($fields)) {
            return $query;
        }

        return $query->where(function ($query) use ($searchTerm, $fields) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'LIKE', "%{$searchTerm}%");
            }
        });
    }

    /**
     * Get search fields for a specific model table
     */
    protected function getSearchFieldsForModel(string $tableName): array
    {
        // Map table names to search configurations
        $tableFieldMap = [
            'tests' => $this->searchFields['tests'],
            'chapters' => $this->searchFields['chapters'],
            'faqs' => $this->searchFields['faqs'],
            'questions' => $this->searchFields['questions'],
        ];

        return $tableFieldMap[$tableName] ?? [];
    }

    /**
     * Configure search fields for a specific model
     */
    public function setSearchFields(string $model, array $fields): self
    {
        $this->searchFields[$model] = $fields;

        return $this;
    }
}
