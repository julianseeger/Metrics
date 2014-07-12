Metrics
=======

Usage
=====

The default ant target "build" will create a distribution at /build/dist.
You may configure it by using the ant file configure.xml:
```bash
ant
cd build/dist

export DATABASE_DIR=/tmp
export ADMIN_USER=admin
export ADMIN_PASSWORD=admin
ant -f configure.xml
```
Afterwards, point the DocumentRoot of your Apache (or similar) to build/dist/web/public

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

## the easy (but slow) way:
```bash
vagrant up
```
and then you can access the dist via http://localhost:9080
;)


Project structure
=================
```
/core           => Core PHP Applicatipn
/web            => Web Binding
    /web/app    => Angular-App with static html
    /web/php    => JSON-Rest-API to publish data from the Core
```
