<?php
// src/Models/SinhvienModel.php
namespace Hzjan\Bai01QuanlySv\Models;
use Hzjan\Bai01QuanlySv\Database;
use PDO;
class SinhvienModel
{
    private $conn;
    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }
    // Lấy tất cả sinh viên
// Nâng cấp hàm getAllStudents để có thể tìm kiếm
    public function getStudents(
        $keyword = null,
        $limit = 5,
        $offset = 0,
        $sortBy = 'id',
        $sortOrder = 'DESC'
    ) {
        // Validate sort parameters to prevent SQL injection from user input
        $allowedSortBy = ['id', 'name', 'email', 'phone', 'course', 'class_name', 'major'];
        if (!in_array($sortBy, $allowedSortBy)) {
            $sortBy = 'id';
        }
        $sortOrder = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC';

        // --- BƯỚC 1: ĐẾM TỔNG SỐ BẢN GHI ---
        $sqlCount = "SELECT COUNT(*) FROM students";
        $params = [];
        if ($keyword) {
            $sqlCount .= " WHERE name LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword";
            $params[':keyword'] = "%{$keyword}%";
        }
        $stmtCount = $this->conn->prepare($sqlCount);
        $stmtCount->execute($params);
        $totalRecords = $stmtCount->fetchColumn();
        // --- BƯỚC 2: LẤY DỮ LIỆU SINH VIÊN THEO PHÂN TRANG ---
        $sqlData = "SELECT * FROM students";
        if ($keyword) {
            $sqlData .= " WHERE name LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword";
        }
        $sqlData .= " ORDER BY {$sortBy} {$sortOrder} LIMIT :limit OFFSET :offset";
        $stmtData = $this->conn->prepare($sqlData);
        // Gán các tham số cho câu lệnh lấy dữ liệu
        if ($keyword) {
            $stmtData->bindParam(
                ':keyword',
                $params[':keyword']
            );
        }
        $stmtData->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmtData->bindParam(
            ':offset',
            $offset,
            PDO::PARAM_INT
        );
        $stmtData->execute();
        $students = $stmtData->fetchAll(PDO::FETCH_ASSOC);
        // --- BƯỚC 3: TRẢ VỀ KẾT QUẢ ---

        return [
            'data' => $students,
            'total' => $totalRecords
        ];
    }
    // Thêm sinh viên mới
    public function addStudent($name, $email, $phone, $course, $class_name, $major, $avatar)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO students (name, email, phone, course, class_name, major, avatar) VALUES (:name, :email, :phone, :course, :class_name, :major, :avatar)"
        );
        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $email = htmlspecialchars(strip_tags($email));
        $phone = htmlspecialchars(strip_tags($phone));
        $course = htmlspecialchars(strip_tags($course));
        $class_name = htmlspecialchars(strip_tags($class_name));
        $major = htmlspecialchars(strip_tags($major));
        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':course', $course);
        $stmt->bindParam(':class_name', $class_name);
        $stmt->bindParam(':major', $major);
        $stmt->bindParam(':avatar', $avatar);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // HÀM THÊM MỚI: Lấy thông tin một sinh viên theo ID (bài 03)
    public function getStudentById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM students

WHERE id = :id");

        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // HÀM THÊM MỚI: Cập nhật thông tin sinh viên (bài 03)
    public function updateStudent($id, $name, $email, $phone, $course, $class_name, $major, $avatar)
    {
        $stmt = $this->conn->prepare(
            "UPDATE students SET name = :name, email = :email, phone = :phone, course = :course, class_name = :class_name, major = :major, avatar = :avatar WHERE id = :id"
        );
        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $email = htmlspecialchars(strip_tags($email));
        $phone = htmlspecialchars(strip_tags($phone));
        $course = htmlspecialchars(strip_tags($course));
        $class_name = htmlspecialchars(strip_tags($class_name));
        $major = htmlspecialchars(strip_tags($major));
        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':course', $course);
        $stmt->bindParam(':class_name', $class_name);
        $stmt->bindParam(':major', $major);
        $stmt->bindParam(':avatar', $avatar);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // HÀM MỚI: Xóa một sinh viên theo ID (bài 4)
    public function deleteStudent($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM students WHERE

id = :id");

        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    /**
     * Lấy các số liệu thống kê về sinh viên
     */
    public function getStatistics()
    {
        $sql = "SELECT COUNT(*) AS total_students, SUM(CASE WHEN email LIKE '%@tdu.edu.vn' THEN 1 ELSE 0 END) AS edu_emails, SUM(CASE WHEN phone LIKE '09%' THEN 1 ELSE 0 END) AS sdt_09 FROM students";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>