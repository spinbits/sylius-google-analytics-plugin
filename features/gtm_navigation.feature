@gtm
Feature: I want to see dedicated gtm navigation event

    @ui
    Scenario: Visit product
        When I open page "en_US/products/knitted-wool-blend-green-cap"
        Then I should have existing gtm event "view_item"
