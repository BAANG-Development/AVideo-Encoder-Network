<?php

/**
 * @brief return true if running in CLI, false otherwise
 * if is set $_GET['ignoreCommandLineInterface'] will return false
 * @return boolean
 */
function isCommandLineInterface() {
    return (empty($_GET['ignoreCommandLineInterface']) && php_sapi_name() === 'cli');
}

if (!isCommandLineInterface()) {
    return die('Command Line only');
}

//streamer config
require_once '../configuration.php';
require_once $global['systemRootPath'] . 'objects/Encoder.php';
$option = 0;
while (strtolower($option) !== 'q') {
    menu();
    //ob_flush();
    $option = trim(readline('What is your option number? '));

    if (strtolower($option) === 'a') {
        $streamerURL = trim(readline('What is the encoder URL? '));
        if (!empty($streamerURL)) {
            if (substr($streamerURL, -1) !== '/') {
                $streamerURL .= "/";
            }
            $name = parse_url($streamerURL, PHP_URL_HOST);
            $encoder = new Encoder(0);
            $encoder->setSiteURL($streamerURL);
            $encoder->setName($name);
            $encoder->setStreamers_id(1);
            $encoder->save();
            echo "$streamerURL added";
        }
    } elseif (strtolower($option) !== 'q') {
        $encoder = new Encoder($option);
        $encoder->delete();
    }
}

echo "Bye";
echo "\n\n";
function menu() {
    echo "\n";
    echo "\n";
    echo "------------------------------------------";
    echo "\n";
    echo "Welcome to AVideo Encoder Network";
    echo "\n\n";
    echo "A - Add new Encoder";
    echo "\n";
    echo "Q - Quit/Exit";
    echo "\n";
    $encoders = Encoder::getAll();
    $count = 2;
    foreach ($encoders as $value) {
        $count++;
        echo "{$value['id']} * Remove {$value['siteURL']}";
        echo "\n";
    }
    echo "__________________________________________";
    echo "\n";
    echo "\n";
}
