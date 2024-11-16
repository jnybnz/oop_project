<?php
require_once 'Person.php';
require_once 'Employee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';
require_once 'CommissionEmployee.php';  // Ensure this is included
require_once 'EmployeeRoster.php';

class Main {

    private EmployeeRoster $roster;
    private int $size;
    private bool $repeat;

    public function start() {
        $this->clear();
        $this->repeat = true;

        $this->size = (int)readline("Enter the Size of the Roster: ");
        if ($this->size < 1) {
            echo "Invalid input. Please try again.\n";
            readline("Press \"Enter\" key to continue...");
            $this->start();
        }

        // Initialize the EmployeeRoster
        $this->roster = new EmployeeRoster($this->size);
        $this->entrance(); // Start the menu entrance
    }

    public function entrance() {
        while ($this->repeat) {
            $this->clear();
            $this->menu();

            $choice = (int)readline("Select an option: ");

            switch ($choice) {
                case 1:
                    $this->addMenu();
                    break;
                case 2:
                    $this->deleteMenu();
                    break;
                case 3:
                    $this->otherMenu();
                    break;
                case 0:
                    $this->repeat = false; // Exit the loop
                    break;
                default:
                    echo "Invalid input. Please try again.\n";
                    readline("Press \"Enter\" key to continue...");
                    break;
            }
        }
        echo "Process Terminated.\n";
        exit;
    }

    public function menu() {
        echo "--- ᴇᴍᴘʟᴏʏᴇᴇ ʀᴏꜱᴛᴇʀ ᴍᴇɴᴜ ---\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";
    }

    public function addMenu() {
        $name = readline("\nEnter Employee Name: ");
        $address = readline("Enter Employee Address: ");
        $age = (int)readline("Enter Employee Age: ");
        $companyName = readline("Enter Company Name: ");

        $this->empType($name, $address, $age, $companyName);
    }

    public function empType($name, $address, $age, $cName) {
        $this->clear();
        echo "--- ᴇᴍᴘʟᴏʏᴇᴇ ᴅᴇᴛᴀɪʟꜱ ---\n";
        echo "Name: $name\n";
        echo "Address: $address\n";
        echo "Age: $age\n";
        echo "Company Name: $cName\n\n";
        echo "[1] Commission Employee\n";
        echo "[2] Hourly Employee\n";
        echo "[3] Piece Worker\n";
        
        $type = (int)readline("Type of Employee: ");
    
        switch ($type) {
            case 1:
                $regularSalary = (float)readline("\nEnter Regular Salary: ");
                $itemsSold = (int)readline("Enter Items Sold: ");
                $commissionRate = (float)readline("Enter Commission Rate(%): "); // Change here
                $employee = new CommissionEmployee($name, $address, $age, $cName, $regularSalary, $itemsSold, $commissionRate);
                $this->roster->add($employee);
                break;
            case 2:
                $hoursWorked = (float)readline("\nEnter Hours Worked: ");
                $rate = (float)readline("Enter Hourly Rate: ");
                $employee = new HourlyEmployee($name, $address, $age, $cName, $hoursWorked, $rate);
                $this->roster->add($employee);
                break;
            case 3:
                $numberItems = (int)readline("\nEnter Number of Items: ");
                $wagePerItem = (float)readline("Enter Wage Per Item: ");
                $employee = new PieceWorker($name, $address, $age, $cName, $numberItems, $wagePerItem);
                $this->roster->add($employee);
                break;
            default:
                echo "Invalid input. Please try again!\n";
                readline("Press \"Enter\" key to continue...");
                $this->empType($name, $address, $age, $cName);
                return; // Exit to avoid repeat calls
        }
    
        $this->repeat(); // Check if user wants to add more employees
    }
    
    

    public function deleteMenu() {
        $this->clear();
        $this->roster->display(); // Display current employees
        $employeeNumber = (int)readline("\nEnter the Employee No. to Delete (Type 0 to cancel): ");

        if ($employeeNumber > 0 && $employeeNumber <= $this->size) {
            $this->roster->remove($employeeNumber);
        } else if ($employeeNumber !== 0) {
            echo "Invalid employee number.\n";
        }

        readline("\nPress \"Enter\" key to continue...");
    }

    public function otherMenu() {
        $this->clear();
        echo "[1] Display\n";
        echo "[2] Count\n";
        echo "[3] Payroll\n";
        echo "[0] Back\n";
        
        $choice = (int)readline("Select Menu: \n");

        switch ($choice) {
            case 1:
                $this->roster->display(); // Display all employees
                break;
            case 2:
                echo "Total Employees: " . $this->roster->count() . "\n";
                echo "Commission Employees: " . $this->roster->countCE() . "\n";
                echo "Hourly Employees: " . $this->roster->countHE() . "\n";
                echo "Piece Workers: " . $this->roster->countPE() . "\n";
                break;
            case 3:
                $this->roster->payroll(); // Display payroll information
                break;
            case 0:
                return; // Exit to the main menu
            default:
                echo "Invalid input. Please try again.\n";
                break;
        }

        readline("\nPress \"Enter\" key to continue...");
        $this->otherMenu();
    }

    public function clear() {
        system('cls'); // Use 'clear' for Unix, 'cls' for Windows
    }

    public function repeat() {
        echo "Employee Added!\n";
        if ($this->roster->count() < $this->size) {
            $c = readline("Add more? (y to continue): ");
            if (strtolower($c) == 'y')
                $this->addMenu();
            else
                $this->entrance();
        } else {
            echo "Roster is Full\n";
            readline("Press \"Enter\" key to continue...");
            $this->entrance();
        }
    }
}

// To start the application
$main = new Main();
$main->start();
