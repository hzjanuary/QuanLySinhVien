<?php
// src/Controllers/SinhvienController.php
namespace Hzjan\Bai01QuanlySv\Controllers;
use Hzjan\Bai01QuanlySv\Models\SinhvienModel;
use Hzjan\Bai01QuanlySv\Core\FlashMessage;

class SinhvienController
{
    private $sinhvienModel;
    public function __construct()
    {
        $this->sinhvienModel = new SinhvienModel();
    }
    // Hiển thị danh sách sinh viên
    public function index()
    {
        // --- CÀI ĐẶT CÁC BIẾN PHÂN TRANG ---
        $recordsPerPage = 5; // Số sinh viên mỗi trang
        $currentPage = isset($_GET['page']) ?
            (int) $_GET['page'] : 1;
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $offset = ($currentPage - 1) * $recordsPerPage;
        $keyword = $_GET['keyword'] ?? null;
        // --- GỌI MODEL ---
        $result = $this->sinhvienModel->getStudents(
            $keyword,
            $recordsPerPage,
            $offset
        );
        $students = $result['data'];
        $totalRecords = $result['total'];
        $totalPages = ceil($totalRecords / $recordsPerPage);
        require_once __DIR__ . '/../Views/sinhvien_list.php';
    }
    // Xử lý thêm sinh viên
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            if (
                !empty($name) && !empty($email) &&

                !empty($phone)
            ) {

                $this->sinhvienModel->addStudent(
                    $name,
                    $email,
                    $phone
                );
                FlashMessage::set('student_action', 'Thêm sinh viên thành công!', 'success');
            } else {
                FlashMessage::set('student_action', 'Thêm sinh viên thất bại!', 'error');
            }
        }
        // Sau khi thêm, chuyển hướng về trang danh sách
        header('Location: index.php');
        exit();
    }
    // PHƯƠNG THỨC MỚI: Hiển thị form chỉnh sửa (bài 03)
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            // Nếu không có id, chuyển hướng về trang chủ
            header('Location: index.php');
            exit();
        }
        // Gọi model để lấy thông tin sinh viên
        $student = $this->sinhvienModel->getStudentById($id);
        // Nạp file view để hiển thị form
        require_once __DIR__ . '/../Views/sinhvien_edit.php';
    }
    // PHƯƠNG THỨC MỚI: Xử lý cập nhật dữ liệu (bài 03)
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            if (
                $id && !empty($name) && !empty($email) &&

                !empty($phone)
            ) {

                $this->sinhvienModel->updateStudent(
                    $id,
                    $name,
                    $email,
                    $phone
                );
                FlashMessage::set('student_action', 'Cập nhật thông tin thành công!', 'success');
            } else {
                FlashMessage::set('student_action', 'Cập nhật thất bại!', 'error');
            }
        }
        // Sau khi cập nhật, chuyển hướng về trang danh sách
        header('Location: index.php');
        exit();
    }
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            if ($this->sinhvienModel->deleteStudent($id)) {
                FlashMessage::set('student_action', 'Xóa sinh viên thành công!', 'success');

            } else {
                FlashMessage::set('student_action', 'Xóa thất bại!', 'error');
            }
        }
        // Gọi model để thực hiện xóa
        // Sau khi xóa, chuyển hướng người dùng về lại trang danh sách
        header('Location: index.php');
        exit();
    }
}