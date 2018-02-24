\page Authentication Authentication

1CRM API calls must include authentication information. The API supports
two authentication methods: Basic and OAuth 2.0.

\ref auth-basic

\ref auth-oauth
    * \ref auth-oauth-owners
    * \ref auth-oauth-scopes
    * \ref auth-oauth-token

\section auth-basic Basic authentication

HTTP Basic authentication is the simplest form of authentication supported by 1CRM API.
It uses 1CRM user name and password, and transmits them in HTTP request headers.
This simplicity is the only advantage of this authentication method. Username and password
are sent in cleartext with each request. Whenever possible, you should prefer OAuth 2.0.

To use basic authentication, you first create an instance of 
[OneCRM\\APIClient\\Authentication\\Basic](@ref OneCRM::APIClient::Authentication::Basic),
passing user name and password to constructor. Then create an API client using this authentication
object:

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient\Authentication;
use OneCRM\APIClient;

$auth = new Authentication\Basic('admin', 'admin');
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
// now $client is ready to make API requests
~~~~~~~~~~~~~

\note
Basic authentication for API is disabled by default. If you want to use it, you have
to enable it first, using 1CRM administration interface.

\section auth-oauth OAuth 2.0 authentication

This authentication method uses access tokens. Before making requests, you need to obtain an
access toke from the API.

In order to make calls to the 1CRM API using OAuth 2.0, you need to register an application,
 or API client. Registered clients are assigned a unique Client ID (client_id) and a unique 
 Client Secret (client_secret). Make sure to store the Client Secret securely.

1CRM supports 2 types of API clients: public and private.

Private API clients can be registered by 1CRM administrator, and are intended for use by your
organization only. Public API clients are managed by 1CRM Corp., and represent 3rd party applications.
If you are developing an application that can be potentially useful for all 1CRM customers,
you should apply for a public API client.

Client ID and Client Secret for private clients are available from 1CRM admin interface.
For public clients, 1CRM will provide Client ID and Client Secret after creating your API CLient.

\subsection auth-oauth-owners Resource owners

One of roles defined by OAuth 2.0 Authorization Framework is Resource Owner:

> An entity capable of granting access to a protected resource.
> When the resource owner is a person, it is referred to as an end-user.

Naturally, in 1CRM, its users are resource owners. API client can be granted access on behalf
of a 1CRM user. But there are many cases, when it is also desirable to allow Contacts to
authenticate themselves: using 1CRM as single sign-on server, customer portals, etc.

1CRM defines two types of Resource Owners: User and Contact. Depending on type of resource
owner you want to authenticate, you use different endpoints. Note that Contact access token only
provides access to Contact's own information such as name, email address and telephone number.

\subsection auth-oauth-scopes Scopes

When requesting access to protected resources, API client can specify the scope of request. 1CRM supports 3 scopes:

* `read` client requests access to read information from 1CRM
* `write` client requests access to write information to 1CRM
* `profile` client requests access to Resource Owner's account information

For Resource Owner of Contact type, only `profile` scope is allowed.
`read` and `write` scopes are subject to limitations set by 1CRM administrator using 1CRM ACL system.

If you do not specify a scope in authorization request, `profile` will be used by default.

\subsection auth-oauth-token Obtaining access token

1CRM API Client library provides several authorization flows

* Authorization Code Grant - use this flow if you want to authorize a web application.
* Resource Owner Password Credentials Grant - use this flow if you want to authenticate directly via 1CRM API using resource owner’s password credentials.
* Client Credentials Grant - use this flow to authorize an application on behalf of predefined 1CRM user. The actual user that gains access in this flow is decided by 1CRM administrator.

\warning
Before using an authorization flow, make sure it is enabled in 1CRM admin interface for the Client ID you are using.

#### Authorization flow parameters

When starting an authorization flow, you first have to prepare an associative array with following options:

* `client_id`: API client ID. Required. Can be omited if `ONECRM_CLIENT_ID` environment variable is set.
* `client_secret`: API client secret. Required.  Can be omited if `ONECRM_CLIENT_SECRET` environment variable is set.
* `redirect_uri`: Redirect URI. Required for Authorization Code flow.  Can be omited if `ONECRM_REDIRECT_URI` environment variable is set.
Must match exactly the Redirect URI set by 1CRM administrator for this specific API client ID.
* `username`: 1CRM user name. Required for Resource Owner Password Credentials flow.  Can be omited if `ONECRM_USERNAME` environment variable is set.
* `password`: 1CRM user password. Required for Resource Owner Password Credentials flow.  Can be omited if `ONECRM_PASSWORD` environment variable is set.
* `scope`: Authorization request scopes, space separated. Optional, defaults to `profile`
* `owner_type`: `user` or `contact`. Default value is `user`
* `state`: CSRF token. Optional

#### Authorization Code grant

This flow is a two-step process. First, you make the user visit a special URI where the user logs into 1CRM
and grants access to your application. After access is granted, the user is redirected to **redirect URI**
that you specify, and authorization code is passed in URI query parameter. Script at that redirect URI now
can obtain an access token.


~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;

$options = [
    'client_id' => '123456789-xxx-whatever',
    'client_secret' => 'top secret',
    'redirect_uri' => 'https://mydomain.com/redirect.php',
    'scope' => 'read write profile',
];

$flow = new APIClient\AuthorizationFlow('https://demo.1crmcloud.com/api.php', $options);

$url = $flow->init('authorization_code');
header('Location: ' . $url);

// or you can make the library to do the redirect for you by passing true
// as second argument to AuthorizationFlow::init()

$flow->init('authorization_code', true);
~~~~~~~~~~~~~

After the user returns to redirect URI, you can obtain an access token from the API:

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

// should be same options as used when calling AuthorizationFlow::init()
$options = [
    'client_id' => '123456789-xxx-whatever',
    'client_secret' => 'top secret',
    'redirect_uri' => 'https://mydomain.com/redirect.php',
    'scope' => 'read write profile',
];

$flow = new APIClient\AuthorizationFlow('https://demo.1crmcloud.com/api.php', $options);

$access_token = $flow->finalize();

$auth = new Authentication\OAuth($access_token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
// now $client is ready to make API requests

~~~~~~~~~~~~~

#### Resource Owner Password Credentials Grant

This grant provides great user experience for web applications and native mobile applications, because it does not require the user to be redirected to 1CRM for password entry. This grant is only available for private API clients.

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$options = [
    'client_id' => '123456789-xxx-whatever',
    'client_secret' => 'top secret',
    'scope' => 'read write profile',
    'username' => 'admin',
    'password' => 'admin',
];

$flow = new APIClient\AuthorizationFlow('https://demo.1crmcloud.com/api.php', $options);

$access_token = $flow->init('password');

$auth = new Authentication\OAuth($access_token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
// now $client is ready to make API requests
~~~~~~~~~~~~~

#### Client Credentials Grant

To enable this grant, 1CRM administrator assigns a user to API client using 1CRM admin interface. After obtaining access token, API client can make requests to the API on behalf of that user. This grant is only available for Resource Owner of User type.

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

// should be same options as used when calling AuthorizationFlow::init()
$options = [
    'client_id' => '123456789-xxx-whatever',
    'client_secret' => 'top secret',
    'scope' => 'read write profile',
];

$flow = new APIClient\AuthorizationFlow('https://demo.1crmcloud.com/api.php', $options);

$access_token = $flow->init('client_credentials');

$auth = new Authentication\OAuth($access_token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
// now $client is ready to make API requests
~~~~~~~~~~~~~

### Resfreshing access tokens

Access tokens have a limited lifetime. 1CRM administator can configure access token expiration
time. After access token has expired, it cannot be used to access the API any more. To continue
using the API, you must refresh an expired access token. To understand how token refreshing works, lets
have a look at access token structure first:

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$options = [
    'client_id' => '123456789-xxx-whatever',
    'client_secret' => 'top secret',
    'scope' => 'read write profile',
    'username' => 'admin',
    'password' => 'admin',
];

$flow = new APIClient\AuthorizationFlow('https://demo.1crmcloud.com/api.php', $options);

$access_token = $flow->init('password');
echo json_encode($access_token, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "token_type": "Bearer",
    "expires_in": 86399,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImI3NzBjZjQzODcxYTRlYWJmODg3ZmMwYmQzOTA5ZTBkZjY2M2U3MjEwNzE4YWVmYjIzNzUxNmNhMzE3YTgzYTk0ZGFlMTE4NTk1NWE3ZGUyIn0.eyJhdWQiOiIxMmVjYjI1Yy0zNWZiLWQyOWUtYmI2Ni01YTkwM2EwNDhiMDYiLCJqdGkiOiJiNzcwY2Y0Mzg3MWE0ZWFiZjg4N2ZjMGJkMzkwOWUwZGY2NjNlNzIxMDcxOGFlZmIyMzc1MTZjYTMxN2E4M2E5NGRhZTExODU5NTVhN2RlMiIsImlhdCI6MTUxOTQ4MzcyNCwibmJmIjoxNTE5NDgzNzI0LCJleHAiOjE1MTk1NzAxMjMsInN1YiI6IlVzZXJzOjEiLCJzY29wZXMiOlsicmVhZCIsIndyaXRlIiwicHJvZmlsZSJdfQ.AUKqkoUPBDWfbX69JLoiwZRhxEox_hXbLXSaO65CFecpsi9iTn-pfNUfBUs7rlHNv1uZis2h3Ia8ZiMOdobLMWlqh6SPnvIgA82J_0BVPDVoSijxF2TZ2v-kKq0KsbBAZcJhMBMw2WTP2Wmcf9m4A92kkKUmmwOvF9B_7WLjZ-hw1VMLLdO4rIWXimvwH0Y6-8Tvc6N2PCp5U2DYPaKxZ1jXgNI3ldJz1nJMmstK3d9IBTPV3SsKdWFHJn48Md9DBGBEy6E5oiCJqj17wimqjbgPzLo3KiR7EcZ5bid7jcR3gXfwFyE3_7nmMkdyoY8nAf6jVnkk72njH_iEjBobEHFPb2WovD8JWMwaEqCQjBVMz9K6UVy31v7Mbo1ulUIiCL5-qqXOIMQ9EfUGCqHtkcMKMZdD4DKeGGc2LJhBCwABUETHtbwab9uMAPb7OFAQUMMNewNidumc7pLRYoUajRdSyt_C_XZ2B8Jh2ASAYoAVXSYkL_6CbjBSMcf6saXp9_QGiujk1LsJpoK6GuKgvYRR3QI8lUsj_SiwamLgghGCe_l_71OezneystWxZ992qTKqEY2_lGtLDT1DggybsyC6hEmxJ_FIkI00mKXoTlL2lQKYc6eMpys6hJyJsF6oTuYPDo3CKsdHjDGxjBVog3wU8dEN3r4Uhe0_5ni-8Cw",
    "refresh_token": "pXppRl+5sqtdImvH+TTZHzcPXaRFDTkf2\/p0T+VPygAcg7JF5N7ZCR5NdIyhdU+IOsfv9wdCohrk6LviVKlRdlT9MLh\/x6aOU3bYXv1vriIakgiM5KGiRIHE\/yxfYbndSf6cTYu4xCPpZSeALu8dpg2r43fK9y9Gl70u2wQtTRARp9cnqMSgzh9wHRRBrtcqOl9\/hlekBZ9\/VMwHQ59s+oVJBsYIryHtUGoVh8n1TkraYl7hPPitHFfnp7pjXSGCdBbEeZpXemeVLjNOmfEIdvoZA5yADJiL3jAvM+8iNRoLPi7Xx0dhITgxf9fcNeK834cWop6WHnhpB\/PpEAOivKnn3+kmS318rsTrIGgbtScqAZICXmjll5Os7zpz\/zUVxWlDOqEzL1IrGvuvjE5JWuVHpeWv9AyoyTUArYwlPQCoH2o\/frXXUiMWI34+Ffw1rOFFkY63D2SEcmNNXXGfyn70Qe6AEmPQoUbVdvnsIikF9J+zkcGg\/3z1FXRfcp7M9CVDnkzA\/osjIwQrHNBvRIoRizouTnRDesg2Au209pIxJUSbCgQeKlve\/5LnNhRK9BS527ikq79rkbxYufTc\/wg7t5pORCh48RV8ScIX+zWllkDItDkDH666o61bVw7vOkXw4Z5NVyNEoon\/WfZMJWTGFJOU681PcR4L0YcHYHU="
}
~~~~~~~~~~~~~

You can use `expires_in` fields to calculate the time when the token expires (the value is in seconds). Any time before the expriration time, you can use the refresh token to obtain a new access token:


~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$options = [
    'client_id' => '123456789-xxx-whatever',
    'client_secret' => 'top secret',
    'scope' => 'read write profile',
];

$flow = new APIClient\AuthorizationFlow('https://demo.1crmcloud.com/api.php', $options);

$access_token = stored_access_token(); // previously obtained access token
$new_token = $flow->refreshToken($access_token['refresh_token']);
echo json_encode($new_token, JSON_PRETTY_PRINT);
~~~~~~~~~~~~~
