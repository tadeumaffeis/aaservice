BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "AACourse" (
	"course_id"	INTEGER,
	"initials"	VARCHAR(10) NOT NULL,
	"name"	VARCHAR(70),
	PRIMARY KEY("course_id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "AASubject" (
	"course_id"	INTEGER NOT NULL,
	"subject_id"	INTEGER NOT NULL,
	"initials"	VARCHAR(10) NOT NULL,
	"name"	VARCHAR(70),
	FOREIGN KEY("course_id") REFERENCES "AACourse"("course_id") ON DELETE RESTRICT ON UPDATE RESTRICT,
	PRIMARY KEY("course_id","subject_id")
);
CREATE TABLE IF NOT EXISTS "AASequenceSubjectId" (
	"sequence"	INTEGER,
	PRIMARY KEY("sequence" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "AAStudents" (
	"course_id"	INTEGER NOT NULL,
	"student_ar"	VARCHAR(20) NOT NULL,
	"name"	VARCHAR(70),
	"email"	VARCHAR(50) NOT NULL,
	FOREIGN KEY("course_id") REFERENCES "AASubject"("course_id") ON DELETE RESTRICT ON UPDATE RESTRICT,
	PRIMARY KEY("course_id","student_ar")
);
CREATE TABLE IF NOT EXISTS "AAEnrolled" (
	"course_id"	INTEGER NOT NULL,
	"subject_id"	INTEGER NOT NULL,
	"student_ar"	VARCHAR(20) NOT NULL,
	FOREIGN KEY("course_id","subject_id") REFERENCES "AASubject"("course_id","subject_id") ON DELETE RESTRICT ON UPDATE RESTRICT,
	PRIMARY KEY("course_id","subject_id","student_ar")
);
CREATE TABLE IF NOT EXISTS "AAClassAssignment" (
	"assignment_id"	INTEGER NOT NULL,
	"text"	TEXT NOT NULL,
	"url"	varchar(200),
	"startdate"	DATE,
	"enddate"	DATE,
	PRIMARY KEY("assignment_id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "AAClassAssignmentFiles" (
	"assignment_id"	INTEGER NOT NULL,
	"file_id"	INTEGER NOT NULL,
	"name"	VARCHAR(50) NOT NULL,
	"code"	TEXT NOT NULL,
	"compilable"	BOOLEAN NOT NULL,
	"readonly"	BOOLEAN NOT NULL,
	"startdate"	DATE NOT NULL,
	"enddate"	DATE NOT NULL,
	FOREIGN KEY("assignment_id") REFERENCES "AAClassAssignment"("assignment_id"),
	PRIMARY KEY("assignment_id","file_id")
);
CREATE TABLE IF NOT EXISTS "AASequenceFileId" (
	"sequence"	INTEGER,
	PRIMARY KEY("sequence" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "AAStudentClassAssignments" (
	"student_ar"	VARCHAR(20) NOT NULL,
	"assignment_id"	INTEGER NOT NULL,
	"startdate"	DATE NOT NULL,
	"enddate"	DATE NOT NULL,
	"score"	NUMERIC NOT NULL,
	FOREIGN KEY("assignment_id") REFERENCES "AAClassAssignment"("assignment_id"),
	FOREIGN KEY("student_ar") REFERENCES "AAStudents"("student_ar"),
	PRIMARY KEY("student_ar","assignment_id")
);
CREATE TABLE IF NOT EXISTS "AAStudentClassAssignmentFiles" (
	"student_ar"	VARCHAR(20) NOT NULL,
	"assignment_id"	INTEGER NOT NULL,
	"file_id"	INTEGER NOT NULL,
	"name"	VARCHAR(50) NOT NULL,
	"code"	TEXT NOT NULL,
	"startdate"	DATE NOT NULL,
	"enddate"	DATE NOT NULL,
	"completed"	BOOLEAN NOT NULL,
	FOREIGN KEY("assignment_id") REFERENCES "AAClassAssignment"("assignment_id"),
	FOREIGN KEY("student_ar") REFERENCES "AAStudents"("student_ar"),
	FOREIGN KEY("file_id") REFERENCES "AAClassAssignmentFiles"("file_id"),
	PRIMARY KEY("student_ar","assignment_id","file_id")
);
CREATE TABLE IF NOT EXISTS "AALogin" (
	"username"	VARCHAR(50) NOT NULL,
	"password"	VARCHAR(50) NOT NULL,
	"temppassword"	BOOLEAN NOT NULL,
	FOREIGN KEY("username") REFERENCES "AAStudents"("email"),
	PRIMARY KEY("username")
);
CREATE INDEX IF NOT EXISTS "AACourse_Index_Cource_Id" ON "AACourse" (
	"course_id"
);
CREATE INDEX IF NOT EXISTS "AAClassAssignment_Index_Assignment_Id" ON "AAClassAssignment" (
	"assignment_id"
);
COMMIT;
