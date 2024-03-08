<?php
require_once('vendor/autoload.php');
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverBy;
$driver = RemoteWebDriver::create('http://localhost:4444', DesiredCapabilities::chrome());
$driver->manage()->window()->maximize();
$driver->get('https://kempsey.greenlightopm.com/search-register?deptName=Development');
$driver->wait(20)->until(
    WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('table.table-striped tbody tr'))
);
$rows = $driver->findElements(WebDriverBy::cssSelector('table.table-striped tbody tr'));
foreach ($rows as $row) {
    $columns = $row->findElements(WebDriverBy::tagName('td'));
    $applicationNumber = $columns[0]->findElement(WebDriverBy::className('blueLink'))->getText();
    printf("Application #: %s\nCreated: %s\nDescription: %s\nProperties: %s\nStatus: %s\n\n",
        $applicationNumber, $columns[1]->getText(), $columns[2]->getText(), $columns[3]->getText(), $columns[4]->getText());
}
$driver->quit();