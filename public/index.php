<?php

chdir(dirname(__DIR__));

require __DIR__ . '/../vendor/autoload.php';

use Geo\Application;
use Geo\Model\GeoRecord;

$env = Dotenv\Dotenv::createArrayBacked(dirname(__DIR__))->load();
$app = Application::getInstance();

$ip = $_POST['ip'] ?? null;

$record = $app->run($env, $ip);

?>

<html lang="en">
<head>
    <title>Geo Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
            crossorigin="anonymous"></script>
</head>
<body class="d-flex flex-column h-100">
<main class="flex-shrink-0">
    <div class="container">
        <h4 class="mt-5 mb-3">Check IP Address</h4>
        <div class="col-4">
            <form method="post" action="/">
                <div class="mb-3">
                    <label>
                        <input name="ip" value="<?php echo $ip; ?>" type="text" class="form-control">
                    </label>
                </div>
                <button type="submit" class="btn btn-outline-primary">Check</button>
            </form>

            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { ?>
                <?php if ($record instanceof GeoRecord) { ?>
                    <ul class="list-group mt-5">
                        <li class="list-group-item">City: <?php echo $record->getCity() ?: ''; ?></li>
                        <li class="list-group-item">Country: <?php echo $record->getCountry() ?: ''; ?></li>
                        <li class="list-group-item">Region: <?php echo $record->getRegion() ?: ''; ?></li>
                    </ul>
                <?php } else { ?>
                    <div class="alert alert-primary mt-5" role="alert">Not found</div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</main>
</body>
</html>

