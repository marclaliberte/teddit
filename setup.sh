#!/bin/bash
#######################
# TEDDIT SETUP SCRIPT #
#######################

# Status indicators
function print_status ()
{
    echo -e "\x1B[01;34m[*]\x1B[0m $1"
}

function print_good ()
{
    echo -e "\x1B[01;32m[*]\x1B[0m $1"
}

function print_error ()
{
    echo -e "\x1B[01;31m[*]\x1B[0m $1"
}

function print_notification ()
{
    echo -e "\x1B[01;33m[*]\x1B[0m $1"
}

# Check if script is running as root or exit
print_status "Checking for root privs.."
if [[ $EUID -ne 0 ]]; then
    print_error "ERROR: SCRIPT MUST BE RUN AS ROOT!\n"
    exit 1
else
    print_good "We are root."
fi

# Ask user for MySQL root password
read -e -p "[?] Enter MySQL root password: " MYSQL_PASS

# Logging setup
logfile=/var/log/teddit_setup.log
mkfifo ${logfile}.pipe
tee < ${logfile}.pipe $logfile &
exec &> ${logfile}.pipe
rm ${logfile}.pipe

###############
# MYSQL SETUP #
###############

print_status "Setting up MySQL database.."

# Prep database creation queries
db1="CREATE DATABASE teddit_db;"
db2="CREATE DATABASE vuln_db;"

# Prep user creation queries
usr="CREATE USER 'teddit'@'localhost' IDENTIFIED BY 'TedditPass';"
priv1="GRANT DROP,CREATE,INSERT,SELECT ON teddit_db.* TO 'teddit'@'localhost';"
priv2="GRANT DROP,CREATE,INSERT,SELECT,DELETE,UPDATE ON vuln_db.* TO 'teddit'@'localhost';"

# Prep database table creation queries
tab1="CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL PRIMARY KEY, title VARCHAR(128), content VARCHAR(2048), user VARCHAR(32), date DATETIME);"
tab2="CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL PRIMARY KEY, title VARCHAR(128), content VARCHAR(2048), sender VARCHAR(32), recipient VARCHAR(32), date DATETIME, unread bool NOT NULL DEFAULT true);"
tab3="CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL PRIMARY KEY, user VARCHAR(32) NOT NULL, pass VARCHAR(256) NOT NULL);"

# Populate tables
ins1="INSERT INTO posts (title,content,user) VALUES('Bitcoiners are blaming slump on the moon','Hold on for dear life!','cryptoking'),('Britain Appoints Ministor For Loneliness','Free hugs welcome','nottheonion'),('Alien sightings are no excuse for filing your tax return late','Seriously','TinFoil'),('Zlatan Ibrahimovic linked to LA Galaxy?','Your annual rumor','Footy12'),('Why is the sky blue?','Because science!','A5thGrader'),('You won\'t believe what this politician said!','Surely this will sink them in the polls... right?','FarLeft'),('This is a joke you\'ve probably heard a million times','Why did you click this? It isn\'t even funny...','ASadPanda'),('Elon Musk admits he is under the control of an AI overlord','To the surprise of no one','JohnConnor'),('Battle Toads wins Game of the Year award','But seriously, do you have Battle Toads?','Chumlee');"

ins2="INSERT INTO users (user,pass) VALUES('jbird1992','channingtatum'),('zorro','supersecure');"

# Switch database commands
sdb1="USE teddit_db;"
sdb2="USE vuln_db;"

# Assign quereis to single variable
q="${db1}${db2}${usr}${priv1}${priv2}${sdb1}${tab1}${tab2}${ins1}${sdb2}${tab3}${ins2}"

# Build Database
mysql -u root -p$MYSQL_PASS -e "$q" &>> $logfile
if [ $? -eq 0 ]; then
    print_good "MySQL database built!"
else
    print_error "MySQL database setup failed. Check $logfile details."
    exit 1
fi

#######################
# WEB DIRECTORY SETUP #
#######################

print_status "Setting up web directory.."

# Move directory
mv teddit/ /var/www &>> $logfile

# Set up log directory
mkdir /var/log/teddit/ &>> $logfile

# Set permissions
chown www-data:adm /var/log/teddit &>> $logfile

print_good "Web directory setup complete!"

################
# APACHE SETUP #
################

print_status "Configuring apache web server.."

# Configure apache
a2enmod rewrite &>> $logfile
mv apache/apache2.conf /etc/apache2/ &>> $logfile
mv apache/000-default.conf /etc/apache2/sites-available &>> $logfile
service apache2 restart &>> $logfile
rmdir apache &>> $logfile

print_good "Aapache setup complete!"

print_good "Setup Complete!"

exit 0
