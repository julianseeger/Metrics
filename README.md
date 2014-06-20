Metrics
=======

Setup
=====

## ubuntu:
```bash
sudo -s
add-apt-repository ppa:chris-lea/node.js
apt-get update
apt-get install ant nodejs
npm install -g yo grunt-cli bower
exit

ant
```

The build will create a directory build/dist where you find a start.sh.
Execute it and you got the project running at http://localhost:9080

Project structure
=================
```
/core           => Core PHP Applicatipn
/web            => Web Binding
    /web/app    => Angular-App with static html
    /web/php    => JSON-Rest-API to publish data from the Core
```
