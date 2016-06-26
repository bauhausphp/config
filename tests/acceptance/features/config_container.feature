Feature: Configuration Container
   In order to load and retrieve configuration
   As an config container client
   I want to inform configurarion info and then retrieve them

   Background:
      Given a config container created using the PHP file "../config-sample.php"

   Scenario Outline: Retrieving simple data
      When I require the item labeled with "<label>"
      Then I should receive the value "<value>"

      Examples:
         | label             | value          |
         | environment       | testing        |
         | debug             | true           |
         | googleMapsApiKey  | ************** |
         | googleAnalyticsId | U-12345678     |

   Scenario Outline: Retrieving sequencial array (or list)
      When I require the item labeled with "<label>"
      Then I should receive the the list "<list>"

      Examples:
         | label    | list      |
         | someList | val1,val2 |

   Scenario Outline: Retrieving associative array
      When I require the item labeled with "<label>"
      Then I should receive another config container with the data "<array>"

      Examples:
         | label    | array                                                      |
         | database | host:localhost,dbname:testing,user:bauhaus,password:secret |
         | someApi  | baseUrl:example.com/api/,token:*********                   |

   Scenario: Trying to retrieve configuration info with non existing label
      When I require the item labeled with "wrong"
      Then the exception "Bauhaus\Config\Exception\ConfigItemNotFound" is throwed with the message:
      """
      No config info found with label 'wrong'
      """
