<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;


class TaskStatsController extends Controller
{
    /**
     * Display a listing of all stats .
     *
     * @return array
     */
    public function index()
    {
        return $this->allTotals();
    }

    /**
     * Get the total number of tasks for a given category.
     *
     * @param \App\Models\Category
     * @return int
     */
    public function categoryTotal(Category $category)
    {
        return count(Task::where('category_id', $category->id)->get());
    }

    /**
     * Get the total number of tasks for all categories.
     *
     * @return array
     */
    public function allTotals()
    {
        $allCategories = Category::get();
        $result = [];
        foreach ($allCategories as $category) {
            $result[$category->name] = $this->categoryTotal($category);
        };
        return $result;
    }
}
