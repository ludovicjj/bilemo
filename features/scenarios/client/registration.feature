@api_all
@api_registration

Feature: As an anonymous user, I need to be able to submit registration request
  Background:
    Given i load the following client :
      | username | password   | email             |
      | johndoe  | passphrase | johndoe@gmail.com |

  Scenario: [Fail] Submit request with invalid payload.
    When I send a "POST" request to "/api/clients" with body :
    """
    {
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
      "username": [
        "Veuillez choisir un pseudo."
      ],
      "password": [
        "Veuillez choisir un mot de passe."
      ],
      "email": [
        "Veuillez saisir une adresse email."
      ]
    }
    """
  Scenario: [Fail] Submit request with already exist username.
    When I send a "POST" request to "/api/clients" with body :
    """
    {
      "username": "johndoe",
      "password": "passphrase",
      "email": "test@yopmail.com"
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
      "username": [
        "Ce pseudo est déjà utilisé."
      ]
    }
    """
  Scenario: [Fail] Submit request with already exist email.
    When I send a "POST" request to "/api/clients" with body :
    """
    {
      "username": "toto",
      "password": "passphrase",
      "email": "johndoe@gmail.com"
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
      "email": [
        "Cette adresse e-mail est déjà utilisée."
      ]
    }
    """
  Scenario: [Fail] Submit request with already exist username and email.
    When I send a "POST" request to "/api/clients" with body :
    """
    {
      "username": "johndoe",
      "password": "passphrase",
      "email": "johndoe@gmail.com"
    }
    """
    Then the response status code should be 400
    And the JSON should be equal to:
    """
    {
      "username": [
        "Ce pseudo est déjà utilisé."
      ],
      "email": [
        "Cette adresse e-mail est déjà utilisée."
      ]
    }
    """
  Scenario: [Success] Submit request with valid data.
    When I send a "POST" request to "/api/clients" with body :
    """
    {
      "username": "toto",
      "password": "passphrase",
      "email": "toto@gmail.com"
    }
    """
    Then the response status code should be 201
    And the response should be empty
    And the client "toto" should exist in database

