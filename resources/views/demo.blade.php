@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-8">
    <div class="container-app">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Layout Demo Page</h1>
            <p class="text-gray-600">Showcase of the OrthoTransfer layout components and styling</p>
        </div>

        <!-- Header Demo -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Header & Navigation</h2>
            <div class="alert-info mb-4">
                <p>The header includes the OrthoTransfer logo on the left, navigation menu items, and user authentication controls on the right. It's fully responsive with a mobile menu.</p>
            </div>
        </div>

        <!-- Components Demo -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Buttons -->
            <div class="card">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Button Components</h3>
                <div class="space-y-4">
                    <div class="flex flex-wrap gap-3">
                        <button class="btn-primary">Primary Button</button>
                        <button class="btn-secondary">Secondary Button</button>
                        <button class="btn-outline">Outline Button</button>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button class="btn-primary" disabled>Disabled Primary</button>
                        <button class="btn-secondary" disabled>Disabled Secondary</button>
                    </div>
                </div>
            </div>

            <!-- Badges -->
            <div class="card">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Badge Components</h3>
                <div class="space-y-3">
                    <div class="flex flex-wrap gap-2">
                        <span class="badge-primary">Primary Badge</span>
                        <span class="badge-secondary">Secondary Badge</span>
                        <span class="badge-success">Success Badge</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="badge-warning">Warning Badge</span>
                        <span class="badge-danger">Danger Badge</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <span class="treatment-badge">Braces</span>
                        <span class="treatment-badge">Invisalign</span>
                        <span class="treatment-badge">Retainers</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Alert Components</h2>
            <div class="space-y-4">
                <div class="alert-info">
                    <strong>Info:</strong> This is an informational alert message.
                </div>
                <div class="alert-success">
                    <strong>Success:</strong> Your profile has been updated successfully!
                </div>
                <div class="alert-warning">
                    <strong>Warning:</strong> Please complete your profile to continue.
                </div>
                <div class="alert-danger">
                    <strong>Error:</strong> There was an error processing your request.
                </div>
            </div>
        </div>

        <!-- Form Components -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Form Components</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="card">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Form Inputs</h3>
                    <form class="space-y-4">
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-input" placeholder="Enter your full name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-input" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Doctor Type</label>
                            <select class="form-select">
                                <option>Select doctor type</option>
                                <option>Orthodontist</option>
                                <option>General Dentist</option>
                                <option>Oral Surgeon</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Additional Information</label>
                            <textarea class="form-textarea" rows="3" placeholder="Tell us more about your needs"></textarea>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Checkboxes & Radio</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="form-label">Treatment Types</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="form-checkbox">
                                    <span class="ml-2">Traditional Braces</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="form-checkbox">
                                    <span class="ml-2">Clear Aligners</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="form-checkbox">
                                    <span class="ml-2">Ceramic Braces</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Preferred Contact Method</label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="contact" class="form-radio">
                                    <span class="ml-2">Email</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="contact" class="form-radio">
                                    <span class="ml-2">Phone</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="contact" class="form-radio">
                                    <span class="ml-2">Text Message</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doctor Cards -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Doctor Profile Cards</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="doctor-card">
                    <div class="flex items-center mb-4">
                        <div class="profile-avatar mr-3">
                            <span>DS</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Dr. Sarah Johnson</h3>
                            <p class="text-sm text-gray-600">Orthodontist</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-3">Specializing in adult orthodontics and clear aligner treatments.</p>
                    <div class="flex flex-wrap gap-1 mb-3">
                        <span class="treatment-badge">Invisalign</span>
                        <span class="treatment-badge">Braces</span>
                    </div>
                    <div class="text-sm text-gray-500">
                        📍 Downtown Medical Center
                    </div>
                </div>

                <div class="doctor-card">
                    <div class="flex items-center mb-4">
                        <div class="profile-avatar mr-3">
                            <span>MC</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Dr. Michael Chen</h3>
                            <p class="text-sm text-gray-600">Pediatric Orthodontist</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-3">Expert in children's orthodontics with 15+ years experience.</p>
                    <div class="flex flex-wrap gap-1 mb-3">
                        <span class="treatment-badge">Pediatric Care</span>
                        <span class="treatment-badge">Early Treatment</span>
                    </div>
                    <div class="text-sm text-gray-500">
                        📍 Children's Dental Clinic
                    </div>
                </div>

                <div class="doctor-card">
                    <div class="flex items-center mb-4">
                        <div class="profile-avatar mr-3">
                            <span>ER</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Dr. Emily Rodriguez</h3>
                            <p class="text-sm text-gray-600">General Dentist</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-3">Comprehensive dental care with orthodontic training.</p>
                    <div class="flex flex-wrap gap-1 mb-3">
                        <span class="treatment-badge">General Dentistry</span>
                        <span class="treatment-badge">Orthodontics</span>
                    </div>
                    <div class="text-sm text-gray-500">
                        📍 Family Dental Practice
                    </div>
                </div>
            </div>
        </div>

        <!-- Typography -->
        <div class="card mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Typography System</h2>
            <div class="space-y-3">
                <h1 class="text-4xl text-heading">Heading 1 - Main Page Title</h1>
                <h2 class="text-3xl text-heading">Heading 2 - Section Title</h2>
                <h3 class="text-2xl text-subheading">Heading 3 - Subsection</h3>
                <h4 class="text-xl text-subheading">Heading 4 - Card Title</h4>
                <p class="text-lg text-body">Large body text for important content</p>
                <p class="text-base text-body">Regular body text for main content</p>
                <p class="text-sm text-muted">Small muted text for secondary information</p>
            </div>
        </div>

        <!-- Footer Demo -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Footer</h2>
            <div class="alert-info">
                <p>The footer includes social media icons on the left, organized links in the center, and copyright information on the right. It features the company information, quick links, and support sections.</p>
            </div>
        </div>
    </div>
</div>
@endsection 