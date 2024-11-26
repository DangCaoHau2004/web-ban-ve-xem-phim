CREATE DATABASE btlweb;
USE btlweb;

CREATE TABLE phim (
    id_phim INT PRIMARY KEY AUTO_INCREMENT,
    ten VARCHAR(255),
    the_loai VARCHAR(100),
    thoi_luong INT,
    link_img VARCHAR(255),
    mo_ta TEXT,
    ngon_ngu VARCHAR(50)
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
id_lich_chieu INT, 
id_phong INT, 
tinh_trang INT, 
cho_da_chon VARCHAR(255), 
ngay_dat DATETIME DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (id_lich_chieu) REFERENCES lich_chieu(id_lich_chieu), 
FOREIGN KEY (id_phong) REFERENCES phong(id_phong) 
);

INSERT INTO phim (ten, the_loai, thoi_luong, link_img, mo_ta, ngon_ngu) 
VALUES
('Venom: Kèo Cuối', 'Khoa học, viễn tưởng', 109, 'https://files.betacorp.vn/media%2fimages%2f2024%2f09%2f19%2fscreenshot%2D2024%2D09%2D19%2D150036%2D150139%2D190924%2D38.png', 
 'Tom Hardy sẽ tái xuất trong bom tấn Venom: The Last Dance (Tựa Việt: Venom: Kèo Cuối) và phải đối mặt với kẻ thù lớn nhất từ trước đến nay - toàn bộ chủng tộc Symbiote Venom: Kèo cuối - Dự kiến khởi chiếu 25.10.2024', 
 'Tiếng Anh'),

('Cô Dâu Hào Môn', 'Tâm lý', 114, 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f09%2fbeta%2D400x633%2D133538%2D091024%2D49.png', 
 'Phim lấy đề tài làm dâu hào môn và khai thác câu chuyện môn đăng hộ đối, lối sống và quy tắc của giới thượng lưu dưới góc nhìn hài hước và châm biếm.', 
 'Tiếng Việt'),

('Thần Dược', 'Kinh dị, Tâm lý', 138, 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f23%2f011124%2Dthan%2Dduoc%2D150349%2D231024%2D98.png', 
 'Elizabeth Sparkle, minh tinh sở hữu vẻ đẹp hút hồn cùng với tài năng được mến mộ nồng nhiệt. Khi đã trải qua một thời kỳ đỉnh cao, nhan sắc dần tàn phai, cô tìm đến những kẻ buôn lậu để mua 1 loại thuốc bí hiểm nhằm “thay da đổi vận”, tạo ra một phiên bản trẻ trung hơn của chính mình.', 
 'Tiếng Anh'),

('Elli Và Bí Ẩn Chiếc Tàu Ma', 'Gia đình, Hoạt hình', 87, 'https://files.betacorp.vn/media%2fimages%2f2024%2f09%2f24%2fscreenshot%2D2024%2D09%2D24%2D151025%2D151106%2D240924%2D11.png', 
 'Khi một hồn ma nhỏ vô gia cư gõ cửa nhà những cư dân lập dị của một Chuyến tàu ma để tìm kiếm một nơi để thuộc về, cô vô tình thu hút sự chú ý từ "thế giới bên ngoài" và phải hợp tác với phi hành đoàn quái vật hỗn tạp trong một nhiệm vụ điên rồ để cứu không chỉ tương lai của Chuyến tàu ma mà còn là cơ hội duy nhất để cuối cùng có một gia đình của riêng mình.', 
 'Tiếng Anh'),

('Ác Quỷ Truy Hồn', 'Kinh dị', 107, 'https://files.betacorp.vn/media%2fimages%2f2024%2f10%2f21%2fscreenshot%2D2024%2D10%2D21%2D133508%2D133602%2D211024%2D93.png', 
 'Vào thời điểm Pak Wiryo khó có thể chết vì ông có "quyền nắm giữ", các con của người vợ đầu và người vợ thứ hai của ông lại đang tranh giành quyền thừa kế.', 
 'Tiếng Indo');

INSERT INTO phong (so_hang, so_cot) VALUES (9, 9);
INSERT INTO phong (so_hang, so_cot) VALUES (8, 10);

INSERT INTO lich_chieu(id_phim, rap_chieu, gio_chieu, id_phong, ds_cho) 
VALUES
(1, 'Nhóm 4', '08:00:00', 1, 'B1 B2 B3'),
(1, 'Nhóm 4', '08:00:00', 2, 'B1 B2 B3'),
(2, 'Nhóm 4', '10:00:00', 1, 'A1 A2 A3'),
(3, 'Nhóm 4', '12:05:00', 1, 'B1 B2 B3'),
(4, 'Nhóm 4', '14:40:00', 1, 'B4 B5 B6'),
(5, 'Nhóm 4', '16:10:00', 1, 'C1 C2 C3'),
(1, 'Nhóm 4', '18:10:00', 1, 'D1 D2 D3'),
(2, 'Nhóm 4', '10:00:00', 2, 'A1 A2 A3'),
(3, 'Nhóm 4', '12:05:00', 2, 'B1 B2 B3'),
(4, 'Nhóm 4', '14:40:00', 2, 'B4 B5 B6'),
(5, 'Nhóm 4', '16:10:00', 2, 'C1 C2 C3'),
(1, 'Nhóm 4', '18:10:00', 2, 'D1 D2 D3');

SET GLOBAL event_scheduler = ON;


CREATE EVENT xoa_ngay_chieu_cu
ON SCHEDULE EVERY 1 DAY STARTS '2024-10-30 00:00:00'
DO
  DELETE FROM lich_chieu
  WHERE DATE(ngay_chieu) < CURDATE();
