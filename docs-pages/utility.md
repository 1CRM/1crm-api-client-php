\page utility Utility methods

### Information about authenticated user

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$token = stored_access_token(); // previously obtained access token
$auth = new Authentication\OAuth($token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
echo json_encode($client->me(), JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "id": "Users:1",
    "name": null,
    "first_name": null,
    "last_name": "Administrator",
    "role": "user",
    "groups": [],
    "email": null
}
~~~~~~~~~~~~~

### 1CRM server version

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$token = stored_access_token(); // previously obtained access token
$auth = new Authentication\OAuth($token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
echo json_encode($client->serverVersion(), JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "version": "8.5.0",
    "authenticated": true,
    "products": [
        "enterprise"
    ]
}
~~~~~~~~~~~~~

This method can be called without authentication:

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$client = new APIClient\Client('https://demo.1crmcloud.com/api.php');
echo json_encode($client->serverVersion(), JSON_PRETTY_PRINT);
~~~~~~~~~~~~~

~~~~~~~~~~~~~
{
    "version": "8.5.0",
    "authenticated": false,
    "products": [
        "enterprise"
    ]
}
~~~~~~~~~~~~~

### Get 1CRM API server public key:

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$token = stored_access_token(); // previously obtained access token
$auth = new Authentication\OAuth($token);
$client = new APIClient\Client('https://demo.1crmcloud.com/api.php', $auth);
echo $client->serverKey();
~~~~~~~~~~~~~

~~~~~~~~~~~~~
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEA4KcMj6As8IE5VvgE8IGm
X+nQC4smrw5BG3QzJAf735RFkHXnGb1CbeE1WHLCol8Hm+u2VphHRLjNW8x7/T+S
QyiBsGY0RZl1fdRG5MKeAPH6z2zPs84p45h1pyitzMHdr0g8fXiNc6qSJ6cCC188
oqx/owTFPdBhciie7avn6JX6HcT9FXdO8GLW4hDQWM2GPMrw9JwJR06zRKI7dyur
RBRAvcX1daUb/w6/N+n+f12iPaKiizOUPTW8Pp3a19NnW+Cg83WhWHF1fcoM6aJ2
2zwJwi1Mg4HEbU7hT5VE5Qc57q0akboLZYDOuOI0g3q13HjJwhxl8OslCP6ukbIQ
NNcxFukflpaGjffPYqvCahEc5UW4woaacdFidP9D13UhGS5tMxS2iOzJxmzgL2cG
bgDocuTFfIxKP3H0EdTeJApGBGNozN0U8s8WqXCgKtlHXGgwJx5VEgdO7kKkk9R4
/XMxheojLObYOS1UygX0kHbW/XyV+zAztjHN4Y9RRVkE06IDHwqR6EqyuRuiCLJY
OUFCO0O8cz/QjvzdpfmF2mb9E6Be6ov7jr5l7i6o2b5EkrcvpD41NZwGArscJu3P
3LEL94V+SQ34ck1Vkdg0Y1LUkBrvEjeh9wgBTOQpVmvZfnjtmxbVLFXRFUfqVQ3X
4LsEpFI2Bc9fZIsrnJ8nr8sCAwEAAQ==
-----END PUBLIC KEY-----

~~~~~~~~~~~~~

This method does not require authentication:

~~~~~~~~~~~~~{.php}
use OneCRM\APIClient;
use OneCRM\APIClient\Authentication;

$client = new APIClient\Client('https://demo.1crmcloud.com/api.php');
echo $client->serverKey();
~~~~~~~~~~~~~

~~~~~~~~~~~~~
-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEA4KcMj6As8IE5VvgE8IGm
X+nQC4smrw5BG3QzJAf735RFkHXnGb1CbeE1WHLCol8Hm+u2VphHRLjNW8x7/T+S
QyiBsGY0RZl1fdRG5MKeAPH6z2zPs84p45h1pyitzMHdr0g8fXiNc6qSJ6cCC188
oqx/owTFPdBhciie7avn6JX6HcT9FXdO8GLW4hDQWM2GPMrw9JwJR06zRKI7dyur
RBRAvcX1daUb/w6/N+n+f12iPaKiizOUPTW8Pp3a19NnW+Cg83WhWHF1fcoM6aJ2
2zwJwi1Mg4HEbU7hT5VE5Qc57q0akboLZYDOuOI0g3q13HjJwhxl8OslCP6ukbIQ
NNcxFukflpaGjffPYqvCahEc5UW4woaacdFidP9D13UhGS5tMxS2iOzJxmzgL2cG
bgDocuTFfIxKP3H0EdTeJApGBGNozN0U8s8WqXCgKtlHXGgwJx5VEgdO7kKkk9R4
/XMxheojLObYOS1UygX0kHbW/XyV+zAztjHN4Y9RRVkE06IDHwqR6EqyuRuiCLJY
OUFCO0O8cz/QjvzdpfmF2mb9E6Be6ov7jr5l7i6o2b5EkrcvpD41NZwGArscJu3P
3LEL94V+SQ34ck1Vkdg0Y1LUkBrvEjeh9wgBTOQpVmvZfnjtmxbVLFXRFUfqVQ3X
4LsEpFI2Bc9fZIsrnJ8nr8sCAwEAAQ==
-----END PUBLIC KEY-----

~~~~~~~~~~~~~
