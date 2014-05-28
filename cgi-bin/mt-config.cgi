## Movable Type Configuration File
##
## This file defines system-wide
## settings for Movable Type. In 
## total, there are over a hundred 
## options, but only those 
## critical for everyone are listed 
## below.
##
## Information on all others can be 
## found at:
##  http://www.movabletype.org/documentation/config

#======== REQUIRED SETTINGS ==========

CGIPath        /cgi-bin/
StaticWebPath  /mt-static/
StaticFilePath /home/ndelena2/public_html/mt-static

#======== DATABASE SETTINGS ==========

ObjectDriver DBI::mysql
Database ndelena2_mt
DBUser ndelena2_mtdb
DBPassword underground
DBHost localhost

#======== MAIL =======================

MailTransfer sendmail
SendMailPath /usr/lib/sendmail
