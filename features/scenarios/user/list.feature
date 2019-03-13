@api_all
@api_list_user

Feature: i need to be able to get client's user catalog
  Background:
    Given i load the following client :
      | username | password   | email             |
      | johndoe  | passphrase | johndoe@gmail.com |

  Scenario: [Fail] Submit request without authentication.
    When I send a "GET" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/users"
    Then the response status code should be 403
    And the JSON node "code" should be equal to 403
    And the JSON node "message" should be equal to "Missing token."

  Scenario: [Success] Submit request when client's user catalog is empty
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "GET" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/users" with body:
    """
    {
    }
    """
    Then the response status code should be 204
    And the response should be empty

  Scenario: [Success] Submit request
    And client have the following user:
      | firstName | lastName | phoneNumber | email          | client  |
      | toto      | dupont   | 0123456789  | toto@gmail.com | johndoe |
      | tata      | dupont   | 0123456788  | tata@gmail.com | johndoe |
    When After authentication on url "/api/login/client" with method "POST" as username "johndoe" and password "passphrase", I send a "GET" request to "/api/clients/aaaaaaaa-aaaa-aaaa-aaaa-aaaaaaaaaaaa/users" with body:
    """
    {
    }
    """
    Then the response status code should be 200
    And the JSON node "root" should have 2 elements