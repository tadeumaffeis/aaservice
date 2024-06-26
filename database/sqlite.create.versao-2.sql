BEGIN TRANSACTION;

DROP TABLE IF EXISTS "AACourse";
DROP TABLE IF EXISTS "AASubject";
DROP TABLE IF EXISTS "AAStudents";
DROP TABLE IF EXISTS "AAEnrolled";
DROP TABLE IF EXISTS "AAAssignments";
DROP TABLE IF EXISTS "AAAssignmentsFinished";
DROP TABLE IF EXISTS "AALogin";


CREATE TABLE IF NOT EXISTS "AACourse" (
	"course_id"	INTEGER,
	"initials"	VARCHAR(10) NOT NULL,
	"name"		VARCHAR(70),
	PRIMARY KEY("course_id")
);
CREATE TABLE IF NOT EXISTS "AASubject" (
	"course_id"	INTEGER NOT NULL,
	"initials"	VARCHAR(10) NOT NULL,
	"name"		VARCHAR(70),
	FOREIGN KEY("course_id") REFERENCES "AACourse"("course_id") ON DELETE RESTRICT ON UPDATE RESTRICT,
	PRIMARY KEY("course_id","initials")
);

CREATE TABLE IF NOT EXISTS "AAStudents" (
	"student_ar"	VARCHAR(20) NOT NULL,
	"name"		VARCHAR(70) NOT NULL,
	"email"		VARCHAR(50) UNIQUE NOT NULL,
	PRIMARY KEY("student_ar")
);

CREATE TABLE IF NOT EXISTS "AAEnrolled" (
	"course_id"	INTEGER NOT NULL,
	"subject_id"	VARCHAR(10) NOT NULL,
	"student_ar"	VARCHAR(20) NOT NULL,
	FOREIGN KEY("course_id","subject_id") REFERENCES "AASubject"("course_id","subject_id") ON DELETE RESTRICT ON UPDATE RESTRICT,
	FOREIGN KEY ("student_ar") REFERENCES "aastudents" ("student_ar"),
	PRIMARY KEY("course_id","subject_id","student_ar")
);

CREATE TABLE IF NOT EXISTS "AAAssignments" (
	"course_id"		INTEGER 	NOT NULL,
	"subject_id"		VARCHAR(10) 	NOT NULL,
	"assignment_id"		VARCHAR(10) 	NOT NULL,
        "student_ar" 		VARCHAR(20) 	NOT NULL,
	"content"		LONGBLOB 	NOT NULL,
	FOREIGN KEY("course_id", "subject_id","student_ar") REFERENCES "AAEnrolled" ("course_id", "subject_id","student_ar"),
	PRIMARY KEY("course_id","subject_id","assignment_id","student_ar")
);

CREATE TABLE IF NOT EXISTS "AAAssignmentsFinished" (
  "course_id" 		INT 		NOT NULL,
  "subject_id" 		VARCHAR(10) 	NOT NULL,
  "assignment_id" 	VARCHAR(10) 	NOT NULL,
  "student_ar" 		VARCHAR(20) 	NOT NULL,
  "content" 		LONGBLOB 	NOT NULL,
  PRIMARY KEY ("course_id","subject_id","assignment_id","student_ar"),
  FOREIGN KEY ("assignment_id") REFERENCES "AAAssignments" ("assignment_id"),
  FOREIGN KEY ("course_id", "subject_id", "student_ar") REFERENCES "AAEnrolled" ("course_id", "subject_id", "student_ar")
);

CREATE TABLE IF NOT EXISTS "AALogin" (
  "username" varchar(50) NOT NULL,
  "password" varchar(50) NOT NULL,
  "temppassword" varchar(50) NOT NULL,
  PRIMARY KEY ("username"),
  FOREIGN KEY ("username") REFERENCES "AAStudents" ("email")
);

COMMIT;