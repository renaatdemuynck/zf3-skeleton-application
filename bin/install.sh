#!/usr/bin/env bash

# Create dir for log files
mkdir -p /vagrant/data/logs

# Create database 'zf3-skeleton-application'
mysql -u root <<-"SQL"
	CREATE DATABASE `zf3-skeleton-application`;
	CREATE USER `zf3-skeleton-application`@`%` IDENTIFIED BY "zf3-skeleton-application";
	GRANT ALL PRIVILEGES ON *.* TO `zf3-skeleton-application`@`%`;
SQL
/vagrant/vendor/bin/doctrine-module orm:schema-tool:create
