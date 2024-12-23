CREATE DATABASE btlweb;
USE btlweb;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ho_ten VARCHAR(100) NOT NULL,
    email VARCHAR(75) NOT NULL,
    mat_khau VARCHAR(50) NOT NULL,
    ngay_sinh DATE NOT NULL,
    gioi_tinh ENUM('Nam', 'Nữ', 'Khác') NOT NULL,
    sdt VARCHAR(15) NOT NULL,
    is_admin INT DEFAULT 0
);

CREATE TABLE phim (
    id_phim INT PRIMARY KEY AUTO_INCREMENT,
    ten VARCHAR(255),
    the_loai VARCHAR(100),
    thoi_luong INT,
    link_img VARCHAR(255),
    mo_ta TEXT,
    ngon_ngu VARCHAR(50),
    img_background VARCHAR(255)
);

CREATE TABLE phong (
    id_phong INT PRIMARY KEY AUTO_INCREMENT,
    so_hang INT,
    so_cot INT
);

CREATE TABLE lich_chieu (
    id_lich_chieu INT PRIMARY KEY AUTO_INCREMENT,
    id_phim INT,
    rap_chieu VARCHAR(255),
    ngay_chieu DATE DEFAULT CURRENT_DATE,
    gio_chieu TIME,
    id_phong INT,
    ds_cho TEXT,
    FOREIGN KEY (id_phim) REFERENCES phim(id_phim),
    FOREIGN KEY (id_phong) REFERENCES phong(id_phong)
);

CREATE TABLE admin_xn ( 
    id_xn INT PRIMARY KEY AUTO_INCREMENT,
    ma_ve VARCHAR(50) UNIQUE,
    id_lich_chieu INT, 
    id_phong INT, 
    tinh_trang INT NOT NULL, 
    cho_da_chon VARCHAR(255), 
    ngay_dat DATETIME DEFAULT CURRENT_TIMESTAMP,
    ngay_het_han DATE NOT NULL,
    id INT NOT NULL,
    FOREIGN KEY (id_lich_chieu) REFERENCES lich_chieu(id_lich_chieu), 
    FOREIGN KEY (id_phong) REFERENCES phong(id_phong),
    FOREIGN KEY (id) REFERENCES users(id)
);

INSERT INTO users (ho_ten, email, mat_khau, ngay_sinh, gioi_tinh, sdt, is_admin)
VALUES 
('Quản Trị Viên', 'admin@example.com', 123456, '1990-01-01', 'Nam', '0123456789', 1);

INSERT INTO phim (ten, the_loai, thoi_luong, link_img, mo_ta, ngon_ngu, img_background) 
VALUES
('Venom: Kèo Cuối', 'Khoa học, viễn tưởng', 109, 
 'https://files.betacorp.vn/media%2fimages%2f2024%2f09%2f19%2fscreenshot%2D2024%2D09%2D19%2D150036%2D150139%2D190924%2D38.png', 
 'Tom Hardy sẽ tái xuất trong bom tấn Venom: The Last Dance (Tựa Việt: Venom: Kèo Cuối) và phải đối mặt với kẻ thù lớn nhất từ trước đến nay - toàn bộ chủng tộc Symbiote Venom: Kèo cuối - Dự kiến khởi chiếu 25.10.2024', 
 'Tiếng Anh', 
 'https://images7.alphacoders.com/136/1368063.jpeg'),

('Công Tử Bạc Liêu', 'Tâm lý, Hài hước', 113, 
 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f16%2f400wx633h%2D162649%2D161024%2D28.jpg', 
 'Lấy cảm hứng từ giai thoại nổi tiếng của nhân vật được mệnh danh là thiên hạ đệ nhất chơi ngông, Công Tử Bạc Liêu là bộ phim tâm lý hài hước, lấy bối cảnh Nam Kỳ Lục Tỉnh xưa của Việt Nam. BA HƠN - Con trai được thương yêu hết mực của ông Hội đồng Lịnh vốn là chủ ngân hàng đầu tiên tại Việt Nam, sau khi du học Pháp về đã sử dụng cả gia sản của mình vào những trò vui tiêu khiển, ăn chơi trác tán – nên được người dân gọi bằng cái tên Công Tử Bạc Liêu.', 
 'Tiếng Việt',
 'https://files.betacorp.vn/media/images/2024/12/02/ctbl-104932-021224-61.png'),

('Thần Dược', 'Kinh dị, Tâm lý', 138, 
 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f23%2f011124%2Dthan%2Dduoc%2D150349%2D231024%2D98.png', 
 'Elizabeth Sparkle, minh tinh sở hữu vẻ đẹp hút hồn cùng với tài năng được mến mộ nồng nhiệt. Khi đã trải qua một thời kỳ đỉnh cao, nhan sắc dần tàn phai, cô tìm đến những kẻ buôn lậu để mua 1 loại thuốc bí hiểm nhằm “thay da đổi vận”, tạo ra một phiên bản trẻ trung hơn của chính mình.', 
 'Tiếng Anh', 
 'https://i.ytimg.com/vi/77n-Tmes9s8/maxresdefault.jpg'),

('Chúa Tể Của Những Chiếc Nhẫn: Cuộc Chiến Của Rohirrim', 'Hành động, Phiêu lưu', 135, 
 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f21%2fscreenshot%2D2024%2D10%2D21%2D140406%2D140455%2D211024%2D18.png', 
 "Lấy bối cảnh 183 năm trước những sự kiện trong bộ ba phim gốc, 'Chúa Tể Của Những Chiếc Nhẫn: Cuộc Chiến Của Rohirrim' kể về số phận của Gia tộc của Helm Hammerhand, vị vua huyền thoại của Rohan. Cuộc tấn công bất ngờ của Wulf, lãnh chúa xảo trá và tàn nhẫn của tộc Dunlending, nhằm báo thù cho cái chết của cha hắn, đã buộc Helm và thần dân của ngài phải chống cự trong pháo đài cổ Hornburg - một thành trì vững chãi sau này được biết đến với tên gọi Helm's Deep. Tình thế ngày càng tuyệt vọng, Héra, con gái của Helm, phải dốc hết sức dẫn dắt cuộc chiến chống lại kẻ địch nguy hiểm, quyết tâm tiêu diệt bọn chúng.", 
 'Tiếng Anh',
 'https://files.betacorp.vn/media/images/2024/12/05/1702x621-100220-051224-90.jpg'),

('Hành Trình Của Moana 2', 'Phiêu lưu, Hoạt hình', 99, 
 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f15%2fscreenshot%2D2024%2D10%2D15%2D135233%2D135334%2D151024%2D46.png', 
 '“Hành Trình của Moana 2” là màn tái hợp của Moana và Maui sau 3 năm, trở lại trong chuyến phiêu lưu cùng với những thành viên mới. Theo tiếng gọi của tổ tiên, Moana sẽ tham gia cuộc hành trình đến những vùng biển xa xôi của Châu Đại Dương và sẽ đi tới vùng biển nguy hiểm, đã mất tích từ lâu. Cùng chờ đón cuộc phiêu lưu của Moana đầy chông gai sắp tới vào 29.11.2024.', 
 'Tiếng Việt',
 'https://lumiere-a.akamaihd.net/v1/images/au_moana2_tvspot_45280612.jpeg?region=0,0,1920,1080');

INSERT INTO phong (so_hang, so_cot) VALUES (9, 9);
INSERT INTO phong (so_hang, so_cot) VALUES (8, 10);

INSERT INTO lich_chieu(id_phim, rap_chieu, gio_chieu, id_phong, ds_cho) 
VALUES
(1, 'Nhóm 5', '08:00:00', 1, 'B1 B2 B3'),
(1, 'Nhóm 5', '08:00:00', 2, 'B1 B2 B3'),
(2, 'Nhóm 5', '10:00:00', 1, 'A1 A2 A3'),
(3, 'Nhóm 5', '12:05:00', 1, 'B1 B2 B3'),
(4, 'Nhóm 5', '14:40:00', 1, 'B4 B5 B6'),
(5, 'Nhóm 5', '16:10:00', 1, 'C1 C2 C3'),
(1, 'Nhóm 5', '18:10:00', 1, 'D1 D2 D3'),
(2, 'Nhóm 5', '10:00:00', 2, 'A1 A2 A3'),
(3, 'Nhóm 5', '12:05:00', 2, 'B1 B2 B3'),
(4, 'Nhóm 5', '14:40:00', 2, 'B4 B5 B6'),
(5, 'Nhóm 5', '16:10:00', 2, 'C1 C2 C3'),
(1, 'Nhóm 5', '18:10:00', 2, 'D1 D2 D3');

SET GLOBAL event_scheduler = ON;


CREATE EVENT xoa_ngay_chieu_cu
ON SCHEDULE EVERY 1 DAY
STARTS '2024-10-30 00:00:00'
DO
  DELETE FROM lich_chieu
  WHERE DATE(ngay_chieu) < CURDATE();

CREATE EVENT xoa_ve_het_han
ON SCHEDULE EVERY 1 DAY
STARTS '2024-10-30 00:00:00'
DO
  DELETE FROM admin_xn
  WHERE DATE(ngay_het_han) < CURDATE();