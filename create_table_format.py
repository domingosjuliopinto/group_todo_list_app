#Use this if the table to use this app hasn't been created on Xampp MySQL DB
import pymysql

connection=pymysql.connect(
    host="localhost",
    user="root",
    db="todo" #Change the name according to your xampp mysql db
    )

cur=connection.cursor()

s='''create table Tasks(
task_id integer primary key,
task varchar(50),
priority integer,
deadline date
)'''

cur.execute(s)

connection.close()
