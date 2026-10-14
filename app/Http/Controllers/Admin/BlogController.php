<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\BlogCategoryServices;
use App\Services\Admin\BlogServices;

class BlogController extends Controller
{
    protected $blogCategoryServices;
    protected $blogServices;

    public function __construct(BlogCategoryServices $blogCategoryServices, BlogServices $blogServices)
    {
        $this->blogCategoryServices = $blogCategoryServices;
        $this->blogServices = $blogServices;
    }

    /**
     * Blogs landing page with links to blog management sections.
     */
    public function index()
    {
        $categoryStats = $this->blogCategoryServices->stats();
        $blogStats = $this->blogServices->statusCounts();

        return view('admin.blogs.index', compact('categoryStats', 'blogStats'));
    }
}
