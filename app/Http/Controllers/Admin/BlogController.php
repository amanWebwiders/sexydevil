<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\BlogCategoryServices;

class BlogController extends Controller
{
    protected $blogCategoryServices;

    public function __construct(BlogCategoryServices $blogCategoryServices)
    {
        $this->blogCategoryServices = $blogCategoryServices;
    }

    /**
     * Blogs landing page with links to blog management sections.
     */
    public function index()
    {
        $categoryStats = $this->blogCategoryServices->stats();

        return view('admin.blogs.index', compact('categoryStats'));
    }
}
