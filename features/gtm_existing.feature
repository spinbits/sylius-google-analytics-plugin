@gtm
Feature: Shop pages should contain GTM code
    In order to have working GTM code
    As a Customer
    I want to see GTM code in source code

    Scenario: Render Google Tag Manager script for unknown visitor
        When a customer with an unknown name visits home page
        Then I should have existing gtm id "G-WX1RJ8SP3R"
