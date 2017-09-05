#!/usr/bin/env bash

# Change working dir to project root
cd "${BASH_SOURCE%/*}/.."

# Install project dependencies with Composer
echo "Installing project dependencies with Composer..."
if [ -d "vendor" ]; then
  echo "'vendor' folder already exists. Skipping."
else
  sudo -H -u ubuntu bash -c 'composer install --no-interaction --no-suggest --no-progress'
fi

# Create local config file
echo "Creating local config file..."
if [ -f "config/autoload/local.config.php" ]; then
  echo "'local.config.php' already exists. Skipping."
else
  cp config/autoload/local.config.php.dist config/autoload/local.config.php
fi

# Create database 'zf3-skeleton-application'
echo "Creating database 'zf3-skeleton-application'..."
if mysql -u root -e 'use zf3-skeleton-application' 2> /dev/null; then
  echo "Database 'zf3-skeleton-application' already exists. Skipping."
else
  # Create the database and user
  mysql -u root <<-"SQL"
		CREATE DATABASE `zf3-skeleton-application` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
		CREATE USER IF NOT EXISTS `zf3-skeleton-application`@`localhost` IDENTIFIED BY "zf3-skeleton-application";
		GRANT ALL PRIVILEGES ON `zf3-skeleton-application`.* TO `zf3-skeleton-application`@`localhost`;
	SQL
  # Save the credentials in the config file
  sed -i "s/'host' => ''/'host' => 'localhost'/" config/autoload/local.config.php
  sed -i "s/'dbname' => ''/'dbname' => 'zf3-skeleton-application'/" config/autoload/local.config.php
  sed -i "s/'user' => ''/'user' => 'zf3-skeleton-application'/" config/autoload/local.config.php
  sed -i "s/'password' => ''/'password' => 'zf3-skeleton-application'/" config/autoload/local.config.php
  # Generate the tables using Doctrine tool
  sudo -H -u ubuntu bash -c 'composer exec doctrine-module orm:schema-tool:create'
fi

# Restore working dir
cd $OLDPWD
