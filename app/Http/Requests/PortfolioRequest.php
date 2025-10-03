<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PortfolioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $portfolioId = $this->route('portfolio') ? $this->route('portfolio')->id : null;

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('portfolios', 'slug')->ignore($portfolioId),
            ],
            'description' => 'required|string|max:1000',
            'content' => 'nullable|string',
            'featured_image' => 'required|string|max:255',
            'gallery' => 'nullable|array',
            'gallery.*' => 'string|max:500',
            'category' => 'required|string|max:100',
            'industry' => 'nullable|string|max:100',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:50',
            'features' => 'nullable|array',
            'features.*' => 'string|max:100',
            'live_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'featured' => 'boolean',
            'published' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'project_duration' => 'nullable|string|max:100',
            'project_budget' => 'nullable|string|max:100',
            'client_name' => 'nullable|string|max:255',
            'results' => 'nullable|string|max:1000',
            'challenge' => 'nullable|string|max:1000',
            'solution' => 'nullable|string|max:1000',
            'impact' => 'nullable|string|max:1000',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'author_id' => 'required|exists:users,id',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The project title is required.',
            'slug.unique' => 'This slug is already taken. Please choose a different one.',
            'slug.regex' => 'The slug must contain only lowercase letters, numbers, and hyphens.',
            'description.required' => 'The project description is required.',
            'featured_image.required' => 'Please provide a featured image for the project.',
            'category.required' => 'Please select a category for the project.',
            'live_url.url' => 'Please provide a valid live URL.',
            'github_url.url' => 'Please provide a valid GitHub URL.',
            'author_id.required' => 'Please specify the author.',
            'author_id.exists' => 'The selected author does not exist.',
        ];
    }
}
