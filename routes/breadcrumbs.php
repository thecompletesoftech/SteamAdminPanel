<?php

use App\Services\ManagerLanguageService;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

$mls = new ManagerLanguageService('lang_breadcrumbs');
// Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
//     $trail->push('Dashboard', route('home.index'));
// });

// Breadcrumbs::for('subcategories', function (BreadcrumbTrail $trail) {
//     $trail->parent('home');
//     $trail->push('SubCategories', route('sub_categories.index'));
// });

/*------------- Admin Dashboard (Admin Home) -------------*/
// Home
Breadcrumbs::for('admin.dashboard', function ($trail) use ($mls) {
    $trail->push($mls->messageLanguage('only_name', 'dashboard', 2), route('admin.dashboard'));
});

Breadcrumbs::for("admin.profile", function ($trail) use ($mls) {
    $trail->parent("admin.dashboard");
    $trail->push($mls->messageLanguage('only_name', 'profile', 2), route("admin.profile"));
});
Breadcrumbs::for("admin.change-password", function ($trail) use ($mls) {
    $trail->parent("admin.dashboard");
    $trail->push($mls->messageLanguage('only_name', 'change_password', 2), route("admin.change_password"));
});

// general Settings
Breadcrumbs::for('admin.settings.edit_general', function ($trail) {
    $trail->parent("admin.dashboard");
    $trail->push('Settings - General', route("admin.settings.edit_general"));
});

Breadcrumbs::macro('resource', function ($name, $title, $list = false) {
    // Home > $title
    Breadcrumbs::for("admin.$name.index", function ($trail) use ($name, $title) {
        $trail->parent("admin.dashboard");
        $trail->push($title, route("admin.$name.index"));
    });

    // Home > $title > Add New
    Breadcrumbs::for("admin.$name.create", function ($trail) use ($name, $title) {
        $trail->parent("admin.$name.index");
        $trail->push("Add New $title", route("admin.$name.create"));
    });
// My Changes
      Breadcrumbs::for("admin.$name.excel", function ($trail) use ($name, $title) {
        $trail->parent("admin.$name.index");
        $trail->push("Add New $title", route("admin.$name.excel"));
    });
//
    // Home > $title > Edit
    Breadcrumbs::for("admin.$name.edit", function ($trail) use ($name, $title) {
        $trail->parent("admin.$name.index");
        $trail->push("Edit $title", url("admin/$name/{id}/edit"));
    });
    // Home > $title > Details
    Breadcrumbs::for("admin.$name.show", function ($trail) use ($name, $title) {
        $trail->parent("admin.$name.index");
        $trail->push(" Details", url("admin/$name/{id}"));
    });
    Breadcrumbs::for("admin.$name.rating", function ($trail) use ($name, $title) {
        $trail->parent("admin.$name.index");
        $trail->push(" Details", url("admin/$name/{id}"));
    });
     Breadcrumbs::for("admin.$name.win", function ($trail) use ($name, $title) {
        $trail->parent("admin.$name.index");
        $trail->push(" Details", url("admin/$name/{id}"));
    });
    if ($list == true) {
        Breadcrumbs::for("admin.$name.list", function ($trail) use ($name, $title) {
            $trail->parent("admin.dashboard");
            $trail->push($title, route("admin.$name.list"));
        });
    }
});

/*------------- Admin Users ------------------------*/
Breadcrumbs::resource('users', $mls->messageLanguage('only_name', 'user', 2));
/*------------- Admin Roles ------------------------*/
Breadcrumbs::resource('roles', $mls->messageLanguage('only_name', 'role', 2));
/*------------- Admin Permissions ------------------------*/
Breadcrumbs::resource('permissions', $mls->messageLanguage('only_name', 'permission', 2));


/*------------- Admin User Intrest ------------------------*/
Breadcrumbs::resource('intrests', $mls->messageLanguage('only_name', 'intrest', 2));


/*------------- Steam house ------------------------*/
Breadcrumbs::resource('steamhouses', $mls->messageLanguage('only_name', 'steamhouse', 2));
/*------------- Map Location ------------------------*/
Breadcrumbs::resource('locations', $mls->messageLanguage('only_name', 'location', 2));
/*------------- Company List ------------------------*/
Breadcrumbs::resource('companylists', $mls->messageLanguage('only_name', 'company', 2));
/*------------- Manager Registration ------------------------*/
Breadcrumbs::resource('managerregistrations', $mls->messageLanguage('only_name', 'managerregistration', 2));
/*------------- Engineer Registration ------------------------*/
Breadcrumbs::resource('employeeregistrations', $mls->messageLanguage('only_name', 'employeeregistration', 2));
/*------------- Service Request ------------------------*/
Breadcrumbs::resource('servicerequests', $mls->messageLanguage('only_name', 'servicerequest', 2));
/*------------- Review Customer ------------------------*/
Breadcrumbs::resource('reviews', $mls->messageLanguage('only_name', 'review', 2));
/*------------- Manager Feedback ------------------------*/
Breadcrumbs::resource('managerfeedbacks', $mls->messageLanguage('only_name', 'managerfeedback', 2));
/*------------- Employee Feedback ------------------------*/
Breadcrumbs::resource('employeefeedbacks', $mls->messageLanguage('only_name', 'employeefeedback', 2));
/*------------- Customer Tracking ------------------------*/
Breadcrumbs::resource('customertrackings', $mls->messageLanguage('only_name', 'customertracking', 2));
/*------------- Admin Notification ------------------------*/
Breadcrumbs::resource('notifications', $mls->messageLanguage('only_name', 'notification', 2));

/*------------- customerdatas ------------------------*/
Breadcrumbs::resource('customerdatas', $mls->messageLanguage('only_name', 'customerdata', 2));


