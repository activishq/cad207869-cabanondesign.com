<?php

chmod("deploy-master.sh", 0755);
chmod("deploy-staging.sh", 0755);

try {
    // Decode JSON data from Github
    $payload = json_decode($_REQUEST['payload']);
}

catch(Exception $e) {
    exit(0);
}

// Deploy production if push was on master branch
if ($payload->ref === 'refs/heads/master') {
    exec('./deploy-master.sh');
    echo 'Deployed -> '. $payload->ref;
}

// Deploy staging if push was on stage branch
if ($payload->ref === 'refs/heads/staging') {
    exec('./deploy-staging.sh');
    echo 'Deployed -> '. $payload->ref;
}
