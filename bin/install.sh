#!/usr/bin/env bash

# Create dir for log files
mkdir -p /vagrant/data/logs

# Create database 'zf3-skeleton-application'
mysql -u root -e 'CREATE DATABASE `zf3-skeleton-application`'
/vagrant/vendor/bin/doctrine-module orm:schema-tool:create