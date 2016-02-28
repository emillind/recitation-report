
CREATE TABLE Course (
  cID   VARCHAR(10)   PRIMARY KEY,
  name  VARCHAR(50)
);

CREATE TABLE Student (
  ID        VARCHAR(10)   PRIMARY KEY,
  name      VARCHAR(50),
  password  VARCHAR(30)
);

CREATE TABLE Recitation (
  cID   VARCHAR(10)   REFERENCES Course(cID),
  num   INT,
  PRIMARY KEY(cID, num)
);

CREATE TABLE RecitationGroup (
  cID   VARCHAR(10),
  num   INT,
  name  VARCHAR(20),
  FOREIGN KEY (cID, num) REFERENCES Recitation(cID, num),
  PRIMARY KEY(cID, num, name)
);

CREATE TABLE Leader (
  ID    VARCHAR(10)   PRIMARY KEY,
  name  VARCHAR(50)
);

CREATE TABLE Problems (
  problemSet  VARCHAR(30),
  condition   VARCHAR(100),
  PRIMARY KEY(problemSet, condition)
);

CREATE TABLE Takes (
  cID         VARCHAR(10)   REFERENCES Course(cID),
  studentID   VARCHAR(10)   REFERENCES Student(ID),
  PRIMARY KEY(cID, studentID)
);

CREATE TABLE Claims (
  studentID   VARCHAR(10)   REFERENCES Student(ID),
  problemSet  VARCHAR(30),
  condition   VARCHAR(100),
  cID         VARCHAR(10),
  recNum      INT,
  groupName   VARCHAR(20),
  claimedSet  VARCHAR(30),
  FOREIGN KEY (problemSet, condition)   REFERENCES Problem(problemSet, condition),
  FOREIGN KEY (cID, recNum, groupName)  REFERENCES RecitationGroup(cID, num, name),
  PRIMARY KEY(studentID, problemSet, condition, cID, recNum, groupName)
);

CREATE TABLE HasProblems (
  cID         VARCHAR(10),
  recNum      INT,
  problemSet  VARCHAR(30),
  condition   VARCHAR(100),
  FOREIGN KEY (cID, recNum) REFERENCES Recitation(cID, num),
  FOREIGN KEY (problemSet, condition) REFERENCES Problems(problemSet, condition),
  PRIMARY KEY(cID, recNum, problemSet, condition)
);

CREATE TABLE LeadsGroup (
  cID         VARCHAR(10),
  recNum      INT,
  groupName   VARCHAR(20),
  leaderID    VARCHAR(10)   REFERENCES Leader(ID),
  FOREIGN KEY (cID, recNum, groupName) REFERENCES RecitationGroup(cID, num, name),
  PRIMARY KEY (cID, recNum, groupName, leaderID)
);

CREATE TABLE Results (
  cID         VARCHAR(10),
  recNum      INT,
  studentID   VARCHAR(10)   REFERENCES Student(ID),
  points      INT,
  FOREIGN KEY (cID, recNum) REFERENCES Recitation(cID, num),
  PRIMARY KEY(cID, recNum, studentID)
);
