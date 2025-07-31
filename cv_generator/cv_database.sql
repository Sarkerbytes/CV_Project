CREATE DATABASE IF NOT EXISTS cv_database;
USE cv_database;

CREATE TABLE IF NOT EXISTS cv_data (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  job_title VARCHAR(255),
  phone VARCHAR(50),
  email VARCHAR(255),
  address TEXT,
  skills TEXT,
  languages TEXT,
  hobbies TEXT,
  profile_summary TEXT,
  work_experience TEXT,
  education TEXT,
  photo VARCHAR(255)
);
