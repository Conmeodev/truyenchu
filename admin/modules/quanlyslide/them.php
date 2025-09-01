<div class="col-md-9 right-column">
    <h2>Đăng Ảnh Mới</h2>
    <form method="post" action="index.php?action=quanlyslide&query=xuly" enctype="multipart/form-data">
        <div class="form-group">
            <label for="hinhanh">Ảnh:</label>
            <input type="file" name="hinhanh" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="thutu">Thứ tự:</label>
            <input type="text" name="thutu" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="tinhtrang">Trạng thái:</label>
            <select name="tinhtrang" class="form-control" required>
                <option value="1">Hiển thị</option>
                <option value="0">Ẩn</option>
            </select>
        </div>

        <input type="submit" name="themanhtrangbia" value="Đăng Ảnh" class="btn btn-primary">
    </form>
</div>
