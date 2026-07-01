<?php

/**
 * ======================================================================
 * Routes Web - Framework BMVC Production
 * ======================================================================
 */

use Core\Middlewares\MiddlewareJWTAuth;
use Core\Routeur;
use Core\Middlewares\MiddlewareAuth;
use Core\Middlewares\MiddlewareCSRF;

// ======== Routes Publiques ========
// Route accueil
Routeur::obtenir('/', 'AccueilControleur@index')->nom('accueil');

// Route page des erreures
Routeur::vue('/403', 'errors.403')->nom('403');
Routeur::vue('/404', 'errors.404')->nom('403');


// Route page de documentation
Routeur::obtenir('/documentation', 'DocumentationControleur@index')->nom('documentation');

// Route page de connexion
Routeur::obtenir('/login', 'AuthControleur@index')->nom('login');
Routeur::obtenir('/logout', 'AuthControleur@logout')->nom('logout');
Routeur::obtenir('/acount/activate', 'AuthControleur@activeAcount')->nom('account.activate');
Routeur::obtenir('/api/auth/me', 'AuthControleur@me')->nom('api.auth.me');
Routeur::obtenir('/get-started', 'AuthControleur@sighin')->nom('register');
Routeur::obtenir('/company/register', 'AuthControleur@registerCompanyPage')->nom('company.register');
Routeur::publier('/company/send-activation', 'AuthControleur@sendActivationEmail')->nom('company.send-activation');

Routeur::obtenir('/company/activate', 'CompanyController@activate')->nom('company.activate');
Routeur::publier('/company/activate', 'CompanyController@activation')->nom('company.activate.post');
Routeur::obtenir('/company/configuration', 'CompanyController@configurationInitiale')->nom('company.configuration');


// ======== API Authentication Endpoints ========
Routeur::publier('/api/auth/login', 'AuthControleur@apiLogin')->nom('api.auth.login');
Routeur::publier('/api/auth/register', 'AuthControleur@apiRegister')->nom('api.auth.register');
Routeur::publier('/api/auth/register-company', 'AuthControleur@apiRegisterCompany')->nom('api.auth.register-company');
Routeur::publier('/api/auth/refresh', 'AuthControleur@apiRefresh')->nom('api.auth.refresh');
Routeur::obtenir('/api/auth/verify', 'AuthControleur@apiVerify')->middleware(MiddlewareJWTAuth::class)->nom('api.auth.verify');
Routeur::publier('/api/auth/logout', 'AuthControleur@apiLogout')->middleware(MiddlewareJWTAuth::class)->nom('api.auth.logout');


Routeur::obtenir('/dashboard', 'dashboardControleur@index')->nom('dashbord.gerent');
Routeur::obtenir('/test', 'dashboardControleur@test')->nom('dashbord.test');
// versement
Routeur::obtenir('/versements', 'versementControleur@index')->nom('versement');
Routeur::obtenir('/api/versement', 'versementControleur@all')->nom('versement');
Routeur::publier('/api/versement', 'versementControleur@store')->nom('versement');



// ======== ONBOARDING WIZARD ROUTES ========
// Welcome page after activation
Routeur::obtenir('/welcome', 'CompanyController@welcome')->nom('welcome');

// Wizard initialization & resumption
Routeur::publier('/api/wizard/init', 'CompanyController@wizardInit')->nom('api.wizard.init');
Routeur::obtenir('/workspace/setup', 'CompanyController@configurationInitiale')->nom('wizard.setup');
Routeur::obtenir('/api/wizard/resume', 'CompanyController@wizardResume')->nom('api.wizard.resume');

// Wizard state management
Routeur::publier('/api/wizard/autosave', 'CompanyController@wizardAutosave')->nom('api.wizard.autosave');

Routeur::publier('/api/wizard/deploy', 'CompanyController@wizardDeploy')->nom('api.wizard.deploy');

// Wizard helper endpoints
Routeur::obtenir('/api/wizard/permissions', 'CompanyController@wizardPermissions')->nom('api.wizard.permissions');
Routeur::publier('/api/wizard/generate-sku', 'CompanyController@wizardGenerateSku')->nom('api.wizard.generate-sku');

// Activation endpoint
Routeur::publier('/api/company/activate', 'CompanyController@apiActivate')->nom('api.company.activate');


//gestion de equipes d'une entreprise
Routeur::vue('/company/team', 'team.index')->nom('company.teams');
Routeur::obtenir('/api/company/teams', 'TeamController@index')->nom('company.teams.index');
Routeur::obtenir('/api/company/teams/list', 'TeamController@all')->nom('company.teams.index');
Routeur::obtenir('/api/company/entrepots', 'TeamController@entrepots')->nom('company.teams.entrepots');
Routeur::obtenir('/api/company/mouvements', 'TeamController@mouvements')->nom('company.teams.mouvements');
Routeur::obtenir('/api/team/data', 'TeamController@data')->nom('company.teams.data');
Routeur::publier('/api/team/invite', 'TeamController@invite')->nom('company.teams.invite');
Routeur::obtenir('/accept-invitation', 'TeamController@accept')->nom('company.teams.invite.accept');
Routeur::publier('/api/accept-invitation', 'TeamController@apiaccept')->nom('company.teams.invite.accept');
