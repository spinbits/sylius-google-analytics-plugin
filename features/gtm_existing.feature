@gtm
Feature: Shop pages should contain GTM code
    In order to have working GTM code
    As a Customer
    I want to see GTM code in source code

    Scenario: Statically greeting a customer with an unknown name
        When a customer with an unknown name visits home page
        Then they should have existing gtm id "G-WX1RJ8SP3R"

    Scenario: Statically greeting a customer with a known name
        When a customer named "Krzysztof" visits home page
        Then they should have existing gtm id "G-WX1RJ8SP3R"
