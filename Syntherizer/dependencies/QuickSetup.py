# Import dependent modules
import sys
import subprocess

import shutil
import os


def dl_db():
    import sys
    import subprocess
    subprocess.check_call([sys.executable, '-m', 'pip', 'install', 
    'mysql '])
    subprocess.check_call([sys.executable, '-m', 'pip', 'install', 
    'mysql-connector-python '])
    # subprocess.check_call([sys.executable, 'winget', 'install', 'xampp']) // Installer included instead


# // Create Database and tables
def create_db():
    Create_DB = """CREATE DATABASE login;
    USE login;
    CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    synth VARCHAR(255) NOT NULL
    );"""
    import mysql.connector
    mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password="root"
    )
    mycursor = mydb.cursor()
    # mycursor.execute("CREATE DATABASE example2;")
    mycursor.execute(Create_DB, multi=True)
    input(Create_DB + '\n \nDatabase created.\nPress Enter')

# // Place the Syntherizer inside htcocs directory
def place_dir():
    # subprocess.check_call([sys.executable, 'Xcopy', '/E', '/I', '..\\Syntherizer' 'C:\\xampp\\htdocs\\test'])
    curdir = os.getcwd()
    # input('Current Directory: ' + curdir)   // FOR DEBUGGING
    os.chdir(curdir)
    # input('Directory changed to: ' +curdir) // FOR DEBUGGING
    frdir = r"..\Syntherizer"
    todir = r"C:\\xampp\\htdocs\\Syntherizer"
    shutil.copytree(frdir, todir)
    input('Copied \nPress enter to open file directory')

# // Opens working directory
def open_dir():
    curdir = os.getcwd()
    os.chdir('C:\\xampp\\htdocs\\Syntherizer')
    os.system('cmd /k "start .."')


dl_db()
import mysql.connector
create_db()
place_dir()
open_dir()