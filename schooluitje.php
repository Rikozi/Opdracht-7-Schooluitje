<?php

// Younes Et-Talby

abstract class Person {
    protected $name;

    public function __construct($name) {
        $this->name = $name;
    }

    abstract public function determineRole();

    public function getName() {
        return $this->name;
    }

    public function getRole() {
        return $this->determineRole();
    }
}

class Teacher extends Person {
    private $salary;

    public function __construct($name, $salary) {
        parent::__construct($name);
        $this->salary = $salary;
    }

    public function determineRole() {
        return "Teacher";
    }

    public function getSalary() {
        return $this->salary;
    }
    public function getTeacherName() {
        return $this->name;
    }
}

class Student extends Person {
    private $paid;

    public function __construct($name, $paid) {
        parent::__construct($name);
        $this->paid = $paid;
    }
    public function getName() {
        return $this->name;
    }

    public function determineRole() {
        return "Student";
    }

    public function hasPaid() {
        return $this->paid;
    }
    public function pay($amount) {
        $this->paid = true;
    }
}

class Group {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }
}

class SchooltripList {
    private $studentList = [];
    private $teacher;

    public function addStudentToList(Student $student) {
        $this->studentList[] = $student;
    }

    public function getStudentLists() {
        return $this->studentList;
    }

    public function setTeacher(Teacher $teacher) {
        $this->teacher = $teacher;
    }

    public function getTeacher() {
        return $this->teacher;
    }
}

class Schooltrip {
    private $name;
    private $schooltripLists = [];
    private $countStudent = 0;
    private $countList = 0;
    private $amount = 0;

    public function __construct($name) {
        $this->name = $name;
    }

    public function addSchooltripList() {
        $this->schooltripLists[] = new SchooltripList();
        $this->countList++;
    }
    public function getName() {
        return $this->name;
    }

    public function addStudent(Student $student) {
        if ($this->countStudent % 5 == 0) {
            $this->addSchooltripList();
        }

        $this->schooltripLists[$this->countList - 1]->addStudentToList($student);
        $this->countStudent++;
    }

    public function getSchooltripLists() {
        return $this->schooltripLists;
    }

    public function getTotalAmount() {
        return $this->amount;
    }

    public function collectPayment(Student $student, $amount) {
        $student->pay($amount);
        $this->amount += $amount;
    }
}

$schoolTrip = new Schooltrip("Fun Trip");


$student1 = new Student("Alice", false);
$student2 = new Student("Bob", false);
$student3 = new Student("Charlie", false);
$student4 = new Student("David", false);
$student5 = new Student("Eve", false);
$student6 = new Student("Frank", false);


$schoolTrip->addStudent($student1);
$schoolTrip->addStudent($student2);
$schoolTrip->addStudent($student3);
$schoolTrip->addStudent($student4);
$schoolTrip->addStudent($student5);
$schoolTrip->addStudent($student6);


$teacher = new Teacher("Mr. Smith", 0);

// maak de trip
$schoolTripList = $schoolTrip->getSchooltripLists()[0];
$schoolTripList->setTeacher($teacher);

echo "School Trip: " . $schoolTrip->getName() ."<br>". PHP_EOL;
foreach ($schoolTrip->getSchooltripLists() as $index => $list) {
    $teacher = $list->getTeacher();

    if ($teacher !== null) {
        echo "Group " . ($index + 1) . " - Teacher: " . $teacher->getTeacherName() . PHP_EOL;
        echo '<br>';
    }

    foreach ($list->getStudentLists() as $student) {
        echo "   Student: " . $student->getName() . PHP_EOL;
    }
}


echo '<br>';
echo '<br>';

$amountToCollect = 1000;
$paid_stud1 = 105;
$paid_stud2 = 125;
$paid_stud3 = 245;
$paid_stud4 = 340;
$schoolTrip->collectPayment($student1, $paid_stud1);
$schoolTrip->collectPayment($student2, $paid_stud2);
$schoolTrip->collectPayment($student3, $paid_stud3);
$schoolTrip->collectPayment($student4, $paid_stud4);
echo "Amount collected from " . $student1->getName() . ": $" . $paid_stud1 . PHP_EOL;
echo '<br>';
echo "Amount collected from " . $student2->getName() . ": $" . $paid_stud2 . PHP_EOL;
echo '<br>';
echo "Amount collected from " . $student3->getName() . ": $" . $paid_stud3 . PHP_EOL;
echo '<br>';
echo "Amount collected from " . $student4->getName() . ": $" . $paid_stud4 . PHP_EOL;
echo '<br>';
echo '<br>';


echo "Total Amount Collected: $" . $schoolTrip->getTotalAmount() . PHP_EOL;
