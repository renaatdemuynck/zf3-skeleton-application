#!/usr/bin/env bash

# Change working dir to project root
cd "${BASH_SOURCE%/*}/.."

# Create dir for log files
mkdir -p data/logs

# Install project dependencies with Composer
echo "Installing project dependencies with Composer..."
if [ -d "vendor" ]; then
  echo "'vendor' folder already exists. Skipping."
else
  composer install
fi

# Create database 'zf3-skeleton-application'
echo "Creating database 'zf3-skeleton-application'..."
if mysql -u root -e 'use zf3-skeleton-application' 2> /dev/null; then
  echo "Database 'zf3-skeleton-application' already exists. Skipping."
else
  mysql -u root <<-"SQL"
		CREATE DATABASE `zf3-skeleton-application`;
		CREATE USER IF NOT EXISTS `zf3-skeleton-application`@`localhost` IDENTIFIED BY "zf3-skeleton-application";
		GRANT ALL PRIVILEGES ON `zf3-skeleton-application`.* TO `zf3-skeleton-application`@`localhost`;
	SQL
  vendor/bin/doctrine-module orm:schema-tool:create
fi

# Restore working dir
cd $OLDPWD

