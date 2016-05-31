Feature: Config Container with read only access
   In order to load and retrieve configuration information
   As an config container user
   I want to inform a pathfile that contains the configuration and then retrieve them

   Background:
      Given a config container loaded with the PHP file "config-sample.php"

   Scenario Outline: Retrieving configurations after inform PHP file
      When I request for the information labeled with "<label>"
      Then I should receive the value "<value>"

      Examples:
         | label             | value          |
         | environment       | testing        |
         | debug             | true           |
         | googleMapsApiKey  | ************** |
         | googleAnalyticsId | U-12345678     |

   Scenario Outline: Accessing second level info as another config container
      When I request for the information labeled with "<label>"
      Then I should receive the another config container with the data "<array>"

      Examples:
         | label    | array                                                      |
         | database | host:localhost,dbname:testing,user:bauhaus,password:secret |
         | someApi  | baseUrl:example.com/api/,token:*********                   |

   Scenario Outline: Trying to retrieve config info that does not exist
      When I request for the information labeled with "<label>"
      Then I should receive the exception "Bauhaus\Config\Exception\ConfigLabelNotFoundException"

      Examples:
         | label       |
         | wrongLabel1 |
         | wrongLabel2 |
