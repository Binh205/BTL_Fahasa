<?php
/**
 * NEWS CONTROLLER
 * Trang Danh sách bài viết và Chi tiết bài viết
 */

class NewsController extends Controller {

    /**
     * Trang danh sách bài viết
     */
    public function index() {
        $search = trim($_GET['search'] ?? '');
        $category = $_GET['category'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 9; // Số bài viết trên mỗi trang
        $offset = ($page - 1) * $limit;

        // Trong thực tế, bạn sẽ truy vấn database để lấy bài viết
        // Dưới đây là dữ liệu mẫu
        $articles = $this->getArticles($search, $category, $limit, $offset);
        $totalArticles = $this->getTotalArticles($search, $category);
        $totalPages = ceil($totalArticles / $limit);

        $data = [
            'title' => 'Tin tức - ' . APP_NAME,
            'page' => 'news',
            'articles' => $articles,
            'search' => $search,
            'category' => $category,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalArticles' => $totalArticles
        ];

        $this->view('news/index', $data);
    }

    /**
     * Trang chi tiết bài viết
     */
    public function detail($id) {
        // Trong thực tế, bạn sẽ truy vấn database để lấy thông tin bài viết
        // Dưới đây là dữ liệu mẫu
        $article = $this->getArticleById($id);

        if (!$article) {
            // Nếu không tìm thấy bài viết, chuyển hướng về trang danh sách
            header('Location: ' . BASE_URL . 'news');
            exit;
        }

        // Lấy bài viết liên quan (cùng danh mục)
        $relatedArticles = $this->getRelatedArticles($article['category'], $id, 3);

        $data = [
            'title' => $article['title'] . ' - ' . APP_NAME,
            'page' => 'news',
            'article' => $article,
            'relatedArticles' => $relatedArticles
        ];

        $this->view('news/detail', $data);
    }

    /**
     * Mô phỏng hàm lấy bài viết từ database
     */
    private function getArticles($search = '', $category = '', $limit = 9, $offset = 0) {
        // Dữ liệu mẫu
        $allArticles = [
            1 => [
                'id' => 1,
                'title' => 'Lợi ích của việc đọc sách mỗi ngày đối với trí não',
                'summary' => 'Đọc sách không chỉ giúp mở rộng kiến thức mà còn cải thiện trí nhớ, tăng khả năng tập trung và giảm căng thẳng hiệu quả...',
                'content' => 'Đọc sách là một trong những hoạt động trí tuệ tốt nhất mà con người có thể thực hiện. Nhiều nghiên cứu khoa học đã chứng minh rằng việc đọc sách thường xuyên mang lại nhiều lợi ích đáng kể cho não bộ và sức khỏe tinh thần. Khi đọc sách, não bộ phải hoạt động tích cực để xử lý thông tin, từ đó kích thích sự phát triển của các kết nối thần kinh. Điều này giúp cải thiện trí nhớ, khả năng tập trung và tư duy logic. Ngoài ra, đọc sách còn giúp giảm căng thẳng, cải thiện giấc ngủ và tăng cường khả năng đồng cảm với người khác.',
                'author' => 'Nguyễn Văn Minh',
                'category' => 'kien-thuc',
                'image' => 'images/news-page/loi-ich-doc-sach-doi-voi-tri-nao.jpg',
                'published_date' => '2024-10-15',
                'views' => 1250,
                'comments' => 34
            ],
            2 => [
                'id' => 2,
                'title' => 'Top 10 cuốn sách nên đọc trong đời',
                'summary' => 'Dưới đây là danh sách 10 cuốn sách kinh điển mà mỗi người nên đọc ít nhất một lần trong đời để mở mang tri thức và hiểu biết...',
                'content' => 'Mỗi cuốn sách là một thế giới, mỗi trang sách là một trải nghiệm mới. Dưới đây là danh sách 10 cuốn sách kinh điển mà bạn nên đọc ít nhất một lần trong đời:\n\n1. Đắc Nhân Tâm - Dale Carnegie: Cuốn sách dạy về cách ứng xử, làm việc và sinh hoạt để đạt được thành công trong cuộc sống.\n\n2. Nhà Giả Kim - Paulo Coelho: Một câu chuyện truyền cảm hứng về việc theo đuổi giấc mơ.\n\n3. Người giàu nhất thành Babylon - George Clason: Những bí quyết làm giàu từ thời cổ đại.\n\n4. Đời Ngắn Đừng Ngủ Dài - Robin Sharma: Giúp bạn thức dậy mỗi ngày với năng lượng và nhiệt huyết.\n\n5. Tư Duy Nhanh và Tư Duy Chậm - Daniel Kahneman: Khám phá hai hệ thống tư duy của con người.\n\n6. Nhà Lãnh Đạo Không Chức Danh - Robin Sharma: Ai cũng có thể trở thành lãnh đạo.\n\n7. Hiểu Về Trái Tim - Minh Niệm: Sách thiền và cảm xúc.\n\n8. Dám Bị Ghét - Ichiro Kishimi: Triết lý sống từ trường phái Adler.\n\n9. Sức Mạnh Của Thói Quen - Charles Duhigg: Bí mật của hiệu suất cá nhân và tổ chức.\n\n10. Sapiens - Yuval Noah Harari: Lịch sử của nhân loại từ thời dựng tộc đến hiện đại.',
                'author' => 'Trần Thị Hằng',
                'category' => 'sach-hay',
                'image' => 'images/news-page/top-10-cuon-sach-nen-doc-trong-doi.jpg',
                'published_date' => '2024-10-10',
                'views' => 2100,
                'comments' => 67
            ],
            3 => [
                'id' => 3,
                'title' => 'Phương pháp đọc sách hiệu quả trong thời đại số',
                'summary' => 'Bạn đang đọc sách nhưng không nhớ được nhiều nội dung? Dưới đây là một số phương pháp đọc sách hiệu quả giúp bạn ghi nhớ tốt hơn...',
                'content' => 'Trong thời đại số, việc đọc sách có nhiều thay đổi so với trước đây. Sự xuất hiện của các thiết bị điện tử mang lại nhiều tiện ích nhưng cũng tạo ra không ít thách thức cho người đọc. Dưới đây là một số phương pháp đọc sách hiệu quả trong thời đại số:\n\n1. Thiết lập thời gian đọc cố định: Dù là sách giấy hay sách điện tử, bạn nên có thời gian đọc cố định mỗi ngày.\n\n2. Tạo không gian đọc yên tĩnh: Tránh xa các thiết bị gây xao nhãng như điện thoại, máy tính bảng khi đọc.\n\n3. Ghi chú khi đọc: Dùng bút chì, bút đánh dấu hoặc tính năng ghi chú trên thiết bị điện tử để ghi lại những ý chính.\n\n4. Đọc với mục đích rõ ràng: Xác định mục tiêu đọc sách để có sự tập trung phù hợp.\n\n5. Ôn lại nội dung đã đọc: Dành thời gian suy ngẫm và ghi chú lại những điều quan trọng sau khi đọc xong.\n\n6. Kết hợp đọc với thực hành: Áp dụng những gì học được từ sách vào cuộc sống thực tế.\n\n7. Đọc sách chất lượng: Chọn sách có nội dung chất lượng thay vì đọc nhiều nhưng hời hợt.',
                'author' => 'Phạm Quốc Trung',
                'category' => 'kien-thuc',
                'image' => 'images/news-page/phuong-phap-doc-sach-hieu-qua-thoi-dai-so.jpg',
                'published_date' => '2024-09-28',
                'views' => 1800,
                'comments' => 42
            ],
            4 => [
                'id' => 4,
                'title' => 'Văn hóa đọc ở Việt Nam: Thách thức và cơ hội',
                'summary' => 'Văn hóa đọc là một phần quan trọng trong phát triển xã hội. Bài viết phân tích thực trạng và đề xuất giải pháp phát triển văn hóa đọc...',
                'content' => 'Văn hóa đọc là một phần không thể thiếu trong quá trình phát triển xã hội và giáo dục con người. Ở Việt Nam, mặc dù đã có những chuyển biến tích cực trong những năm gần đây, nhưng văn hóa đọc vẫn còn nhiều thách thức cần được giải quyết.\n\nThực trạng hiện nay:\n\n- Tỷ lệ người đọc sách còn thấp so với các nước phát triển\n- Thiếu thói quen đọc sách từ nhỏ\n- Thiếu không gian đọc phù hợp\n- Sự cạnh tranh từ các hình thức giải trí khác\n\nGiải pháp phát triển văn hóa đọc:\n\n1. Tăng cường đầu tư cho thư viện công cộng\n2. Tổ chức các sự kiện văn hóa đọc\n3. Đưa văn hóa đọc vào trường học từ cấp tiểu học\n4. Tạo môi trường đọc sách thân thiện\n5. Khuyến khích các hoạt động đọc sách trong gia đình\n6. Phát triển sách chất lượng cao\n7. Ứng dụng công nghệ trong việc phổ biến sách\n\nTuy nhiên, bên cạnh thách thức, vẫn có nhiều cơ hội để phát triển văn hóa đọc ở Việt Nam. Sự phát triển của công nghệ, sự quan tâm của xã hội, và nhu cầu học hỏi của người dân là những yếu tố thuận lợi để xây dựng một xã hội ham đọc sách.',
                'author' => 'Lê Thị Bích Ngọc',
                'category' => 'van-hoa',
                'image' => 'images/news-page/van-hoa-doc-vietnam.jpg',
                'published_date' => '2024-09-20',
                'views' => 1500,
                'comments' => 28
            ],
            5 => [
                'id' => 5,
                'title' => 'Sách và vai trò trong giáo dục hiện đại',
                'summary' => 'Trong thời đại công nghệ phát triển, sách vẫn giữ vai trò quan trọng trong quá trình giáo dục và phát triển tư duy...',
                'content' => 'Dù công nghệ thông tin ngày càng phát triển, sách vẫn giữ vai trò không thể thay thế trong giáo dục và phát triển tư duy con người. Sách không chỉ là phương tiện truyền đạt kiến thức mà còn là công cụ hình thành nhân cách, phát triển khả năng tư duy phản biện và sáng tạo.\n\nVai trò của sách trong giáo dục hiện đại:\n\n1. Nguồn kiến thức đáng tin cậy: Sách là nguồn thông tin đã qua kiểm duyệt, đánh giá và được đánh giá cao về độ tin cậy.\n\n2. Hình thành tư duy logic: Việc đọc sách giúp người đọc hình thành khả năng suy luận logic, phân tích và đánh giá thông tin.\n\n3. Rèn luyện kỹ năng đọc hiểu: Đây là kỹ năng cơ bản và quan trọng trong học tập và làm việc.\n\n4. Phát triển ngôn ngữ: Sách là công cụ hiệu quả để học từ vựng, ngữ pháp và phong cách viết.\n\n5. Giáo dục đạo đức và nhân cách: Qua những câu chuyện, bài học trong sách, người đọc học được những giá trị đạo đức và cách sống.\n\n6. Phản tư và tự học: Sách giúp người đọc có thời gian phản tư về bản thân và thế giới xung quanh.\n\nTuy nhiên, để sách phát huy hết vai trò trong giáo dục hiện đại, cần có sự đổi mới trong nội dung và hình thức xuất bản, cũng như nâng cao nhận thức về vai trò của sách trong xã hội.',
                'author' => 'Hoàng Văn Cường',
                'category' => 'giao-duc',
                'image' => 'images/news-page/sach-va-vai-tro-trong-giao-duc-hien-dai.jpg',
                'published_date' => '2024-09-15',
                'views' => 1300,
                'comments' => 31
            ],
            6 => [
                'id' => 6,
                'title' => 'Xu hướng xuất bản sách điện tử năm 2024',
                'summary' => 'Sách điện tử ngày càng phát triển và trở thành xu hướng trong ngành xuất bản hiện đại...',
                'content' => 'Năm 2024 ghi nhận nhiều thay đổi tích cực trong xu hướng xuất bản sách điện tử. Với sự phát triển của công nghệ và nhu cầu đọc sách tiện lợi, sách điện tử đã trở thành lựa chọn phổ biến của nhiều độc giả.\n\nCác xu hướng nổi bật:\n\n1. Tăng trưởng mạnh về doanh số sách điện tử: Theo báo cáo của các nền tảng xuất bản, doanh số sách điện tử tăng trưởng 40% so với năm 2023.\n\n2. Đa dạng hóa nội dung: Ngoài sách văn học, sách giáo dục, xu hướng sách kỹ năng, sách âm thanh cũng phát triển mạnh.\n\n3. Tích hợp công nghệ AI: Nhiều nền tảng bắt đầu sử dụng trí tuệ nhân tạo để cá nhân hóa trải nghiệm đọc sách.\n\n4. Sự kết hợp giữa sách giấy và sách điện tử: Nhiều nhà xuất bản cung cấp cả hai định dạng để phục vụ đa dạng nhu cầu.\n\n5. Tăng cường bảo mật bản quyền: Công nghệ chống sao chép được cải thiện để bảo vệ quyền lợi tác giả và nhà xuất bản.\n\n6. Phát triển nền tảng đọc sách xã hội: Cho phép người đọc chia sẻ nhận xét, đánh giá và tương tác với cộng đồng.\n\n7. Tích hợp sách nói: Nhiều nền tảng cung cấp cả sách điện tử và sách nói để tăng trải nghiệm người đọc.\n\nTuy nhiên, sách điện tử vẫn đối mặt với một số thách thức như: cạnh tranh từ các nền tảng giải trí, vấn đề bản quyền, và thói quen đọc sách truyền thống của một bộ phận độc giả.',
                'author' => 'Nguyễn Thị Mai',
                'category' => 'cong-nghe',
                'image' => 'images/news-page/xu-huong-xuat-ban-sach-dien-tu-nam-2024.jpg',
                'published_date' => '2024-08-25',
                'views' => 1100,
                'comments' => 25
            ],
            7 => [
                'id' => 7,
                'title' => 'Thư viện số: Giải pháp cho thời đại mới',
                'summary' => 'Thư viện số đang trở thành xu hướng phát triển mạnh mẽ trong thời đại công nghệ số...',
                'content' => 'Thư viện số là mô hình thư viện ứng dụng công nghệ thông tin để số hóa tài liệu và cung cấp dịch vụ thông tin cho người dùng qua môi trường mạng. Đây là xu hướng phát triển tất yếu trong thời đại số.\n\nLợi ích của thư viện số:\n\n1. Truy cập dễ dàng: Người dùng có thể truy cập tài liệu mọi lúc, mọi nơi\n2. Tiết kiệm không gian: Không cần diện tích vật lý lớn\n3. Chi phí bảo quản thấp: Không bị ảnh hưởng bởi thời tiết, mối mọt\n4. Khả năng lưu trữ lớn: Số lượng tài liệu không giới hạn\n5. Dễ dàng tìm kiếm: Công cụ tìm kiếm mạnh mẽ giúp nhanh chóng tìm được tài liệu cần\n6. Hỗ trợ nhiều định dạng: Sách, báo, tạp chí, video, âm thanh\n\nTuy nhiên, thư viện số cũng đối mặt với thách thức:\n\n1. Yêu cầu kỹ năng công nghệ từ người dùng\n2. Vấn đề bản quyền nội dung\n3. Phụ thuộc vào hạ tầng công nghệ thông tin\n4. Nguy cơ mất dữ liệu nếu không có biện pháp sao lưu\n\nMột số quốc gia đã thành công trong việc xây dựng thư viện số như Mỹ, Singapore, Hàn Quốc. Việt Nam cần học hỏi kinh nghiệm để phát triển mô hình phù hợp với điều kiện thực tế.',
                'author' => 'Đỗ Quang Vinh',
                'category' => 'cong-nghe',
                'image' => 'images/news-page/thu-vien-so-giai-phap-cho-thoi-dai-moi.jpg',
                'published_date' => '2024-08-10',
                'views' => 950,
                'comments' => 18
            ],
            8 => [
                'id' => 8,
                'title' => 'Sách thiếu nhi và vai trò trong phát triển trí tuệ trẻ em',
                'summary' => 'Sách thiếu nhi đóng vai trò quan trọng trong việc hình thành nhân cách và phát triển trí tuệ cho trẻ em...',
                'content' => 'Sách thiếu nhi là loại sách được thiết kế đặc biệt cho trẻ em, thường có hình ảnh minh họa sinh động, nội dung ngắn gọn, dễ hiểu và mang tính giáo dục cao. Vai trò của sách thiếu nhi trong sự phát triển của trẻ em là vô cùng quan trọng.\n\nVai trò chính:\n\n1. Phát triển ngôn ngữ: Sách giúp trẻ mở rộng vốn từ, học cách diễn đạt ý tưởng và giao tiếp hiệu quả.\n\n2. Hình thành nhân cách: Qua những câu chuyện, trẻ học được các giá trị đạo đức, phép ứng xử và cách sống.\n\n3. Kích thích trí tưởng tượng: Hình ảnh minh họa và nội dung hấp dẫn giúp trẻ phát triển trí tưởng tượng.\n\n4. Rèn luyện tư duy logic: Việc theo dõi cốt truyện giúp trẻ phát triển kỹ năng tư duy.\n\n5. Giáo dục cảm xúc: Sách giúp trẻ nhận biết, hiểu và kiểm soát cảm xúc của mình.\n\n6. Tạo thói quen đọc sách: Hình thành thói quen đọc sách từ nhỏ là nền tảng cho việc học tập suốt đời.\n\n7. Kết nối gia đình: Việc đọc sách cùng con là cách để cha mẹ gắn kết với con cái.\n\nĐể lựa chọn sách phù hợp cho trẻ, phụ huynh cần lưu ý:\n\n- Độ tuổi của trẻ\n- Sở thích cá nhân\n- Nội dung tích cực, phù hợp chuẩn mực đạo đức\n- Hình ảnh minh họa đẹp, hấp dẫn\n- Có thể khuyến khích trẻ tự chọn sách theo sở thích',
                'author' => 'Phan Thị Hương',
                'category' => 'giao-duc',
                'image' => 'images/news-page/sach-thieu-nhi-va-vai-tro.jpg',
                'published_date' => '2024-07-20',
                'views' => 1400,
                'comments' => 45
            ],
            9 => [
                'id' => 9,
                'title' => 'Sách kinh doanh và kỹ năng sống - xu hướng đọc của giới trẻ',
                'summary' => 'Sách về kinh doanh và kỹ năng sống đang trở thành xu hướng đọc phổ biến trong giới trẻ hiện nay...',
                'content' => 'Trong bối cảnh thị trường lao động cạnh tranh gay gắt, giới trẻ ngày càng quan tâm đến việc trang bị kỹ năng mềm và kiến thức kinh doanh. Sách về kinh doanh và kỹ năng sống đã trở thành một trong những thể loại được ưa chuộng nhất hiện nay.\n\nLý do sách kinh doanh và kỹ năng sống được ưa chuộng:\n\n1. Nhu cầu thực tế: Giới trẻ cần kỹ năng để thành công trong công việc và cuộc sống\n\n2. Khả năng ứng dụng cao: Nội dung sách thường có thể áp dụng trực tiếp vào thực tế\n\n3. Truyền cảm hứng: Nhiều cuốn sách truyền cảm hứng thành công từ những người nổi tiếng\n\n4. Kỹ năng cần thiết: Gồm kỹ năng giao tiếp, làm việc nhóm, quản lý thời gian, tư duy phản biện\n\n5. Tư duy kinh doanh: Học cách lập kế hoạch, ra quyết định và tư duy chiến lược\n\nTuy nhiên, người đọc cũng cần lưu ý:\n\n- Chọn sách từ tác giả, dịch giả uy tín\n- Kết hợp đọc sách với thực hành\n- Không nên chỉ đọc một chủ đề mà cần đa dạng hóa\n- Áp dụng những gì học được vào thực tế\n- Đánh giá sách sau khi đọc để chọn lựa những cuốn phù hợp hơn\n\nSách kinh doanh và kỹ năng sống không chỉ giúp người đọc phát triển bản thân mà còn định hướng con đường sự nghiệp rõ ràng hơn.',
                'author' => 'Vũ Minh Tuấn',
                'category' => 'ky-nang',
                'image' => 'images/news-page/sach-kinh-doanh-va-ky-nang-song-xu-huong-doc-cua-gioi-tre.jpg',
                'published_date' => '2024-07-05',
                'views' => 1600,
                'comments' => 52
            ]
        ];

        // Lọc bài viết theo tìm kiếm
        if (!empty($search)) {
            $filteredArticles = [];
            foreach ($allArticles as $article) {
                if (stripos($article['title'], $search) !== false ||
                    stripos($article['summary'], $search) !== false ||
                    stripos($article['content'], $search) !== false) {
                    $filteredArticles[] = $article;
                }
            }
            $allArticles = $filteredArticles;
        }

        // Lọc bài viết theo danh mục
        if (!empty($category) && $category !== 'all') {
            $filteredArticles = [];
            foreach ($allArticles as $article) {
                if ($article['category'] === $category) {
                    $filteredArticles[] = $article;
                }
            }
            $allArticles = $filteredArticles;
        }

        // Phân trang
        $totalArticles = count($allArticles);
        $articles = array_slice($allArticles, $offset, $limit);

        return $articles;
    }

    /**
     * Mô phỏng hàm lấy tổng số bài viết (cho phân trang)
     */
    private function getTotalArticles($search = '', $category = '') {
        $allArticles = $this->getArticles($search, $category);
        return count($allArticles);
    }

    /**
     * Mô phỏng hàm lấy bài viết theo ID
     */
    private function getArticleById($id) {
        $articles = [
            1 => [
                'id' => 1,
                'title' => 'Lợi ích của việc đọc sách mỗi ngày đối với trí não',
                'summary' => 'Đọc sách không chỉ giúp mở rộng kiến thức mà còn cải thiện trí nhớ, tăng khả năng tập trung và giảm căng thẳng hiệu quả...',
                'content' => 'Đọc sách là một trong những hoạt động trí tuệ tốt nhất mà con người có thể thực hiện. Nhiều nghiên cứu khoa học đã chứng minh rằng việc đọc sách thường xuyên mang lại nhiều lợi ích đáng kể cho não bộ và sức khỏe tinh thần. Khi đọc sách, não bộ phải hoạt động tích cực để xử lý thông tin, từ đó kích thích sự phát triển của các kết nối thần kinh. Điều này giúp cải thiện trí nhớ, khả năng tập trung và tư duy logic. Ngoài ra, đọc sách còn giúp giảm căng thẳng, cải thiện giấc ngủ và tăng cường khả năng đồng cảm với người khác.\n\nNghiên cứu được thực hiện bởi các nhà khoa học tại Đại học Yale cho thấy những người đọc sách thường xuyên có tuổi thọ cao hơn trung bình từ 2-3 năm so với những người không đọc sách. Nghiên cứu theo dõi hơn 3.600 người trong 12 năm và phát hiện rằng thói quen đọc sách có liên quan đến việc giảm nguy cơ tử vong.\n\nNgoài ra, đọc sách còn giúp:\n\n1. Cải thiện trí nhớ: Khi đọc, bạn phải nhớ các nhân vật, cốt truyện, và chi tiết, điều này giúp rèn luyện trí nhớ.\n\n2. Tăng khả năng tập trung: Trong thời đại công nghệ với nhiều sự xao nhãng, đọc sách giúp rèn luyện khả năng tập trung cao độ.\n\n3. Giảm căng thẳng: Đọc sách trong 6 phút có thể giảm mức độ căng thẳng lên đến 68%.\n\n4. Tăng cường khả năng giao tiếp: Đọc sách mở rộng vốn từ vựng và giúp bạn diễn đạt tốt hơn.\n\n5. Ngăn ngừa bệnh Alzheimer: Các hoạt động trí tuệ như đọc sách có thể làm chậm quá trình suy giảm trí nhớ khi về già.\n\n6. Cải thiện chất lượng giấc ngủ: Việc đọc sách trước khi ngủ giúp thư giãn và dễ chìm vào giấc ngủ hơn so với việc sử dụng thiết bị điện tử.\n\n7. Phát triển tư duy phản biện: Đọc sách giúp bạn học cách đánh giá thông tin, phân tích lập luận và đưa ra quyết định.\n\nTất cả những lợi ích này khiến việc đọc sách trở thành một trong những hoạt động có lợi nhất cho sức khỏe tinh thần và thể chất của con người.',
                'author' => 'Nguyễn Văn Minh',
                'category' => 'kien-thuc',
                'image' => 'images/news-page/loi-ich-doc-sach-doi-voi-tri-nao.jpg',
                'published_date' => '2024-10-15',
                'views' => 1250,
                'comments' => 34
            ],
            2 => [
                'id' => 2,
                'title' => 'Top 10 cuốn sách nên đọc trong đời',
                'summary' => 'Dưới đây là danh sách 10 cuốn sách kinh điển mà mỗi người nên đọc ít nhất một lần trong đời để mở mang tri thức và hiểu biết...',
                'content' => 'Mỗi cuốn sách là một thế giới, mỗi trang sách là một trải nghiệm mới. Dưới đây là danh sách 10 cuốn sách kinh điển mà bạn nên đọc ít nhất một lần trong đời:\n\n1. Đắc Nhân Tâm - Dale Carnegie\n\nĐây là quyển sách đầu tiên trong lịch sử bán được hơn 15 triệu bản và được dịch ra gần 40 thứ tiếng trên thế giới. Cuốn sách đưa ra những nguyên tắc cơ bản và sâu sắc về cách ứng xử, làm việc và sinh hoạt để đạt được thành công trong cuộc sống. Đây là quyển sách duy nhất về thể loại self-help bán chạy nhất mọi thời đại.\n\n2. Nhà Giả Kim - Paulo Coelho\n\nMột cậu bé chăn cừu người Tây Ban Nha tên Santiago dấn thân vào một cuộc hành trình theo đuổi giấc mơ và tìm kiếm kho báu được tiết lộ trong giấc mơ của mình. Trong hành trình đó, cậu học được nhiều điều về bản thân và khám phá ra "Ngôn ngữ của thế giới". Cuốn tiểu thuyết phiêu lưu này đã được dịch ra hơn 80 ngôn ngữ và bán hơn 150 triệu bản, trở thành một trong những cuốn sách bán chạy nhất mọi thời đại.\n\n3. Người giàu nhất thành Babylon - George Clason\n\nCuốn sách mang đến những bài học về quản lý tài chính và làm giàu thông qua những câu chuyện cổ tích Babylon. Đây là cuốn sách kinh doanh bán chạy nhất mọi thời đại, dạy cho bạn những nguyên tắc cơ bản về kiếm tiền, tiết kiệm và đầu tư.\n\n4. Đời Ngắn Đừng Ngủ Dài - Robin Sharma\n\nTác phẩm đã truyền cảm hứng cho hàng triệu người trên thế giới để thức dậy mỗi ngày với năng lượng, hiệu suất và cảm giác tuyệt vời. Robin Sharma, cựu luật sư nổi tiếng, chia sẻ công cụ thiết thực và những chiến lược mạnh mẽ đã giúp hàng ngàn doanh nhân, vận động viên, diễn viên và các nhà lãnh đạo hàng đầu đạt được thành công vĩ đại.\n\n5. Tư Duy Nhanh và Tư Duy Chậm - Daniel Kahneman\n\nCuốn sách khám phá hai hệ thống tư duy chi phối cách chúng ta suy nghĩ: hệ thống nhanh và hệ thống chậm. Một hệ thống nhanh ra quyết định một cách trực giác và cảm tính, hệ thống còn lại thì chậm hơn, có tính toán và logic. Cuốn sách làm sáng tỏ nhiều đặc tính kỳ lạ của tư duy con người, từ ảo tưởng nhận thức đến cách ra quyết định tài chính, cũng như đánh giá hạnh phúc và lựa chọn xã hội.\n\n6. Nhà Lãnh Đạo Không Chức Danh - Robin Sharma\n\nCuốn sách truyền cảm hứng cho độc giả rằng ai cũng có thể trở thành một nhà lãnh đạo, không phải bởi chức vụ mà bởi hành động. Robin Sharma giới thiệu một câu chuyện truyền cảm hứng về một nhân viên bình thường tên là Blake Mycoskie, người đang đối mặt với sự trì trệ trong cuộc sống và công việc.\n\n7. Hiểu Về Trái Tim - Minh Niệm\n\nCuốn sách giúp người đọc hiểu rõ hơn về bản thân và cảm xúc của mình, từ đó sống an nhiên và hạnh phúc hơn. Tác phẩm đưa người đọc vào hành trình khám phá nội tâm, giúp nhận diện và hiểu được những cảm xúc, suy nghĩ thường trực trong tâm hồn.\n\n8. Dám Bị Ghét - Ichiro Kishimi & Fumitake Koga\n\nCuốn sách truyền cảm hứng để bạn dám sống đúng là chính mình, không bị ràng buộc bởi kỳ vọng của người khác. Dựa trên triết lý của nhà tâm lý học Alfred Adler, cuốn sách mang đến một cái nhìn khác về cuộc sống và cách con người tương tác với nhau.\n\n9. Sức Mạnh Của Thói Quen - Charles Duhigg\n\nCuốn sách giải thích cách hình thành và thay đổi thói quen, đồng thời khám phá sức mạnh của thói quen trong việc tạo nên hiệu suất cá nhân, thành công của tổ chức và nền văn hóa xã hội. Cuốn sách cung cấp công cụ thực tế để hiểu và thay đổi thói quen của chính bạn.\n\n10. Sapiens - Yuval Noah Harari\n\nMột tác phẩm đồ sộ kể lại lịch sử của nhân loại từ thời dựng tộc đến hiện đại. Cuốn sách khám phá cách con người hiện đại đã chinh phục thế giới và lý do vì sao con người có thể hợp tác với nhau theo quy mô lớn như vậy.',
                'author' => 'Trần Thị Hằng',
                'category' => 'sach-hay',
                'image' => 'images/news-page/top-10-cuon-sach-nen-doc-trong-doi.jpg',
                'published_date' => '2024-10-10',
                'views' => 2100,
                'comments' => 67
            ],
            3 => [
                'id' => 3,
                'title' => 'Phương pháp đọc sách hiệu quả trong thời đại số',
                'summary' => 'Bạn đang đọc sách nhưng không nhớ được nhiều nội dung? Dưới đây là một số phương pháp đọc sách hiệu quả giúp bạn ghi nhớ tốt hơn...',
                'content' => 'Trong thời đại số, việc đọc sách có nhiều thay đổi so với trước đây. Sự xuất hiện của các thiết bị điện tử mang lại nhiều tiện ích nhưng cũng tạo ra không ít thách thức cho người đọc. Dưới đây là một số phương pháp đọc sách hiệu quả trong thời đại số:\n\n1. Thiết lập thời gian đọc cố định\n\nDù là sách giấy hay sách điện tử, bạn nên có thời gian đọc cố định mỗi ngày. Việc tạo thói quen này giúp não bộ quen với việc tiếp nhận thông tin vào một khung giờ nhất định. Nghiên cứu cho thấy rằng đọc sách vào buổi sáng hoặc trước khi ngủ là thời điểm hiệu quả nhất.\n\n2. Tạo không gian đọc yên tĩnh\n\nTránh xa các thiết bị gây xao nhãng như điện thoại, máy tính bảng khi đọc. Nếu bạn đang đọc sách điện tử, hãy tắt các thông báo và sử dụng chế độ đọc sách tập trung. Không gian đọc nên yên tĩnh, ánh sáng vừa đủ, và thoải mái để bạn có thể tập trung cao độ.\n\n3. Ghi chú khi đọc\n\nDùng bút chì, bút đánh dấu hoặc tính năng ghi chú trên thiết bị điện tử để ghi lại những ý chính. Ghi chú giúp bạn tương tác chủ động với nội dung, từ đó tăng khả năng ghi nhớ. Bạn có thể sử dụng các phương pháp như:\n- Gạch chân các đoạn quan trọng\n- Ghi chú bên lề\n- Vẽ sơ đồ tư duy\n- Viết tóm tắt từng chương\n\n4. Đọc với mục đích rõ ràng\n\nXác định mục tiêu đọc sách để có sự tập trung phù hợp. Bạn đọc để giải trí, học tập, hay tìm kiếm giải pháp cho vấn đề cụ thể? Mục đích rõ ràng sẽ giúp bạn chọn sách phù hợp và đọc hiệu quả hơn.\n\n5. Ôn lại nội dung đã đọc\n\nDành thời gian suy ngẫm và ghi chú lại những điều quan trọng sau khi đọc xong. Bạn có thể viết một đoạn tóm tắt ngắn, hoặc thảo luận với người khác về nội dung sách. Việc lặp lại thông tin sẽ củng cố trí nhớ dài hạn.\n\n6. Kết hợp đọc với thực hành\n\nÁp dụng những gì học được từ sách vào cuộc sống thực tế. Việc thực hành giúp bạn hiểu sâu hơn và nhớ lâu hơn những kiến thức đã học. Nếu bạn đọc sách về kỹ năng giao tiếp, hãy thực hành những kỹ thuật trong giao tiếp hàng ngày.\n\n7. Đọc sách chất lượng\n\nChọn sách có nội dung chất lượng thay vì đọc nhiều nhưng hời hợt. Một cuốn sách hay đọc nhiều lần thường mang lại nhiều giá trị hơn nhiều cuốn sách đọc lướt qua. Hãy chọn sách từ tác giả uy tín, được đánh giá cao bởi độc giả và chuyên gia.\n\n8. Ứng dụng công nghệ hỗ trợ\n\nSử dụng các công cụ số để hỗ trợ việc đọc như:\n- Ứng dụng quản lý sách điện tử\n- Công cụ ghi chú thông minh\n- Ứng dụng tạo sơ đồ tư duy\n- Ứng dụng tổng hợp nội dung sách\n\nCuối cùng, hãy nhớ rằng việc đọc sách hiệu quả không nằm ở số lượng mà ở chất lượng. Một ngày đọc một trang sách hiệu quả hơn một ngày đọc hàng trăm trang mà không hiểu và không ghi nhớ được gì.',
                'author' => 'Phạm Quốc Trung',
                'category' => 'kien-thuc',
                'image' => 'images/news-page/phuong-phap-doc-sach-hieu-qua-thoi-dai-so.jpg',
                'published_date' => '2024-09-28',
                'views' => 1800,
                'comments' => 42
            ],
            4 => [
                'id' => 4,
                'title' => 'Văn hóa đọc ở Việt Nam: Thách thức và cơ hội',
                'summary' => 'Văn hóa đọc là một phần quan trọng trong phát triển xã hội. Bài viết phân tích thực trạng và đề xuất giải pháp phát triển văn hóa đọc...',
                'content' => 'Văn hóa đọc là một phần không thể thiếu trong quá trình phát triển xã hội và giáo dục con người. Ở Việt Nam, mặc dù đã có những chuyển biến tích cực trong những năm gần đây, nhưng văn hóa đọc vẫn còn nhiều thách thức cần được giải quyết.\n\nThực trạng hiện nay:\n\n- Tỷ lệ người đọc sách còn thấp so với các nước phát triển\n- Thiếu thói quen đọc sách từ nhỏ\n- Thiếu không gian đọc phù hợp\n- Sự cạnh tranh từ các hình thức giải trí khác\n\nGiải pháp phát triển văn hóa đọc:\n\n1. Tăng cường đầu tư cho thư viện công cộng\n2. Tổ chức các sự kiện văn hóa đọc\n3. Đưa văn hóa đọc vào trường học từ cấp tiểu học\n4. Tạo môi trường đọc sách thân thiện\n5. Khuyến khích các hoạt động đọc sách trong gia đình\n6. Phát triển sách chất lượng cao\n7. Ứng dụng công nghệ trong việc phổ biến sách\n\nTuy nhiên, bên cạnh thách thức, vẫn có nhiều cơ hội để phát triển văn hóa đọc ở Việt Nam. Sự phát triển của công nghệ, sự quan tâm của xã hội, và nhu cầu học hỏi của người dân là những yếu tố thuận lợi để xây dựng một xã hội ham đọc sách.',
                'author' => 'Lê Thị Bích Ngọc',
                'category' => 'van-hoa',
                'image' => 'images/news-page/van-hoa-doc-vietnam.jpg',
                'published_date' => '2024-09-20',
                'views' => 1500,
                'comments' => 28
            ],
            5 => [
                'id' => 5,
                'title' => 'Sách và vai trò trong giáo dục hiện đại',
                'summary' => 'Trong thời đại công nghệ phát triển, sách vẫn giữ vai trò quan trọng trong quá trình giáo dục và phát triển tư duy...',
                'content' => 'Dù công nghệ thông tin ngày càng phát triển, sách vẫn giữ vai trò không thể thay thế trong giáo dục và phát triển tư duy con người. Sách không chỉ là phương tiện truyền đạt kiến thức mà còn là công cụ hình thành nhân cách, phát triển khả năng tư duy phản biện và sáng tạo.\n\nVai trò của sách trong giáo dục hiện đại:\n\n1. Nguồn kiến thức đáng tin cậy: Sách là nguồn thông tin đã qua kiểm duyệt, đánh giá và được đánh giá cao về độ tin cậy.\n\n2. Hình thành tư duy logic: Việc đọc sách giúp người đọc hình thành khả năng suy luận logic, phân tích và đánh giá thông tin.\n\n3. Rèn luyện kỹ năng đọc hiểu: Đây là kỹ năng cơ bản và quan trọng trong học tập và làm việc.\n\n4. Phát triển ngôn ngữ: Sách là công cụ hiệu quả để học từ vựng, ngữ pháp và phong cách viết.\n\n5. Giáo dục đạo đức và nhân cách: Qua những câu chuyện, bài học trong sách, người đọc học được những giá trị đạo đức và cách sống.\n\n6. Phản tư và tự học: Sách giúp người đọc có thời gian phản tư về bản thân và thế giới xung quanh.\n\nTuy nhiên, để sách phát huy hết vai trò trong giáo dục hiện đại, cần có sự đổi mới trong nội dung và hình thức xuất bản, cũng như nâng cao nhận thức về vai trò của sách trong xã hội.',
                'author' => 'Hoàng Văn Cường',
                'category' => 'giao-duc',
                'image' => 'images/news-page/sach-va-vai-tro-trong-giao-duc-hien-dai.jpg',
                'published_date' => '2024-09-15',
                'views' => 1300,
                'comments' => 31
            ],
            6 => [
                'id' => 6,
                'title' => 'Xu hướng xuất bản sách điện tử năm 2024',
                'summary' => 'Sách điện tử ngày càng phát triển và trở thành xu hướng trong ngành xuất bản hiện đại...',
                'content' => 'Năm 2024 ghi nhận nhiều thay đổi tích cực trong xu hướng xuất bản sách điện tử. Với sự phát triển của công nghệ và nhu cầu đọc sách tiện lợi, sách điện tử đã trở thành lựa chọn phổ biến của nhiều độc giả.\n\nCác xu hướng nổi bật:\n\n1. Tăng trưởng mạnh về doanh số sách điện tử: Theo báo cáo của các nền tảng xuất bản, doanh số sách điện tử tăng trưởng 40% so với năm 2023.\n\n2. Đa dạng hóa nội dung: Ngoài sách văn học, sách giáo dục, xu hướng sách kỹ năng, sách âm thanh cũng phát triển mạnh.\n\n3. Tích hợp công nghệ AI: Nhiều nền tảng bắt đầu sử dụng trí tuệ nhân tạo để cá nhân hóa trải nghiệm đọc sách.\n\n4. Sự kết hợp giữa sách giấy và sách điện tử: Nhiều nhà xuất bản cung cấp cả hai định dạng để phục vụ đa dạng nhu cầu.\n\n5. Tăng cường bảo mật bản quyền: Công nghệ chống sao chép được cải thiện để bảo vệ quyền lợi tác giả và nhà xuất bản.\n\n6. Phát triển nền tảng đọc sách xã hội: Cho phép người đọc chia sẻ nhận xét, đánh giá và tương tác với cộng đồng.\n\n7. Tích hợp sách nói: Nhiều nền tảng cung cấp cả sách điện tử và sách nói để tăng trải nghiệm người đọc.\n\nTuy nhiên, sách điện tử vẫn đối mặt với một số thách thức như: cạnh tranh từ các nền tảng giải trí, vấn đề bản quyền, và thói quen đọc sách truyền thống của một bộ phận độc giả.',
                'author' => 'Nguyễn Thị Mai',
                'category' => 'cong-nghe',
                'image' => 'images/news-page/xu-huong-xuat-ban-sach-dien-tu-nam-2024.jpg',
                'published_date' => '2024-08-25',
                'views' => 1100,
                'comments' => 25
            ],
            7 => [
                'id' => 7,
                'title' => 'Thư viện số: Giải pháp cho thời đại mới',
                'summary' => 'Thư viện số đang trở thành xu hướng phát triển mạnh mẽ trong thời đại công nghệ số...',
                'content' => 'Thư viện số là mô hình thư viện ứng dụng công nghệ thông tin để số hóa tài liệu và cung cấp dịch vụ thông tin cho người dùng qua môi trường mạng. Đây là xu hướng phát triển tất yếu trong thời đại số.\n\nLợi ích của thư viện số:\n\n1. Truy cập dễ dàng: Người dùng có thể truy cập tài liệu mọi lúc, mọi nơi\n2. Tiết kiệm không gian: Không cần diện tích vật lý lớn\n3. Chi phí bảo quản thấp: Không bị ảnh hưởng bởi thời tiết, mối mọt\n4. Khả năng lưu trữ lớn: Số lượng tài liệu không giới hạn\n5. Dễ dàng tìm kiếm: Công cụ tìm kiếm mạnh mẽ giúp nhanh chóng tìm được tài liệu cần\n6. Hỗ trợ nhiều định dạng: Sách, báo, tạp chí, video, âm thanh\n\nTuy nhiên, thư viện số cũng đối mặt với thách thức:\n\n1. Yêu cầu kỹ năng công nghệ từ người dùng\n2. Vấn đề bản quyền nội dung\n3. Phụ thuộc vào hạ tầng công nghệ thông tin\n4. Nguy cơ mất dữ liệu nếu không có biện pháp sao lưu\n\nMột số quốc gia đã thành công trong việc xây dựng thư viện số như Mỹ, Singapore, Hàn Quốc. Việt Nam cần học hỏi kinh nghiệm để phát triển mô hình phù hợp với điều kiện thực tế.',
                'author' => 'Đỗ Quang Vinh',
                'category' => 'cong-nghe',
                'image' => 'images/news-page/thu-vien-so-giai-phap-cho-thoi-dai-moi.jpg',
                'published_date' => '2024-08-10',
                'views' => 950,
                'comments' => 18
            ],
            8 => [
                'id' => 8,
                'title' => 'Sách thiếu nhi và vai trò trong phát triển trí tuệ trẻ em',
                'summary' => 'Sách thiếu nhi đóng vai trò quan trọng trong việc hình thành nhân cách và phát triển trí tuệ cho trẻ em...',
                'content' => 'Sách thiếu nhi là loại sách được thiết kế đặc biệt cho trẻ em, thường có hình ảnh minh họa sinh động, nội dung ngắn gọn, dễ hiểu và mang tính giáo dục cao. Vai trò của sách thiếu nhi trong sự phát triển của trẻ em là vô cùng quan trọng.\n\nVai trò chính:\n\n1. Phát triển ngôn ngữ: Sách giúp trẻ mở rộng vốn từ, học cách diễn đạt ý tưởng và giao tiếp hiệu quả.\n\n2. Hình thành nhân cách: Qua những câu chuyện, trẻ học được các giá trị đạo đức, phép ứng xử và cách sống.\n\n3. Kích thích trí tưởng tượng: Hình ảnh minh họa và nội dung hấp dẫn giúp trẻ phát triển trí tưởng tượng.\n\n4. Rèn luyện tư duy logic: Việc theo dõi cốt truyện giúp trẻ phát triển kỹ năng tư duy.\n\n5. Giáo dục cảm xúc: Sách giúp trẻ nhận biết, hiểu và kiểm soát cảm xúc của mình.\n\n6. Tạo thói quen đọc sách: Hình thành thói quen đọc sách từ nhỏ là nền tảng cho việc học tập suốt đời.\n\n7. Kết nối gia đình: Việc đọc sách cùng con là cách để cha mẹ gắn kết với con cái.\n\nĐể lựa chọn sách phù hợp cho trẻ, phụ huynh cần lưu ý:\n\n- Độ tuổi của trẻ\n- Sở thích cá nhân\n- Nội dung tích cực, phù hợp chuẩn mực đạo đức\n- Hình ảnh minh họa đẹp, hấp dẫn\n- Có thể khuyến khích trẻ tự chọn sách theo sở thích',
                'author' => 'Phan Thị Hương',
                'category' => 'giao-duc',
                'image' => 'images/news-page/sach-thieu-nhi-va-vai-tro.jpg',
                'published_date' => '2024-07-20',
                'views' => 1400,
                'comments' => 45
            ],
            9 => [
                'id' => 9,
                'title' => 'Sách kinh doanh và kỹ năng sống - xu hướng đọc của giới trẻ',
                'summary' => 'Sách về kinh doanh và kỹ năng sống đang trở thành xu hướng đọc phổ biến trong giới trẻ hiện nay...',
                'content' => 'Trong bối cảnh thị trường lao động cạnh tranh gay gắt, giới trẻ ngày càng quan tâm đến việc trang bị kỹ năng mềm và kiến thức kinh doanh. Sách về kinh doanh và kỹ năng sống đã trở thành một trong những thể loại được ưa chuộng nhất hiện nay.\n\nLý do sách kinh doanh và kỹ năng sống được ưa chuộng:\n\n1. Nhu cầu thực tế: Giới trẻ cần kỹ năng để thành công trong công việc và cuộc sống\n\n2. Khả năng ứng dụng cao: Nội dung sách thường có thể áp dụng trực tiếp vào thực tế\n\n3. Truyền cảm hứng: Nhiều cuốn sách truyền cảm hứng thành công từ những người nổi tiếng\n\n4. Kỹ năng cần thiết: Gồm kỹ năng giao tiếp, làm việc nhóm, quản lý thời gian, tư duy phản biện\n\n5. Tư duy kinh doanh: Học cách lập kế hoạch, ra quyết định và tư duy chiến lược\n\nTuy nhiên, người đọc cũng cần lưu ý:\n\n- Chọn sách từ tác giả, dịch giả uy tín\n- Kết hợp đọc sách với thực hành\n- Không nên chỉ đọc một chủ đề mà cần đa dạng hóa\n- Áp dụng những gì học được vào thực tế\n- Đánh giá sách sau khi đọc để chọn lựa những cuốn phù hợp hơn\n\nSách kinh doanh và kỹ năng sống không chỉ giúp người đọc phát triển bản thân mà còn định hướng con đường sự nghiệp rõ ràng hơn.',
                'author' => 'Vũ Minh Tuấn',
                'category' => 'ky-nang',
                'image' => 'images/news-page/sach-kinh-doanh-va-ky-nang-song-xu-huong-doc-cua-gioi-tre.jpg',
                'published_date' => '2024-07-05',
                'views' => 1600,
                'comments' => 52
            ]
        ];

        return $articles[$id] ?? null;
    }

    /**
     * Mô phỏng hàm lấy bài viết liên quan
     */
    private function getRelatedArticles($category, $currentId, $limit = 3) {
        $allArticles = [
            1 => [
                'id' => 1,
                'title' => 'Lợi ích của việc đọc sách mỗi ngày đối với trí não',
                'summary' => 'Đọc sách không chỉ giúp mở rộng kiến thức mà còn cải thiện trí nhớ, tăng khả năng tập trung và giảm căng thẳng hiệu quả...',
                'author' => 'Nguyễn Văn Minh',
                'category' => 'kien-thuc',
                'image' => 'images/news-page/loi-ich-doc-sach-doi-voi-tri-nao.jpg',
                'published_date' => '2024-10-15',
                'views' => 1250
            ],
            2 => [
                'id' => 2,
                'title' => 'Top 10 cuốn sách nên đọc trong đời',
                'summary' => 'Dưới đây là danh sách 10 cuốn sách kinh điển mà mỗi người nên đọc ít nhất một lần trong đời để mở mang tri thức và hiểu biết...',
                'author' => 'Trần Thị Hằng',
                'category' => 'sach-hay',
                'image' => 'images/news-page/top-10-cuon-sach-nen-doc-trong-doi.jpg',
                'published_date' => '2024-10-10',
                'views' => 2100
            ],
            3 => [
                'id' => 3,
                'title' => 'Phương pháp đọc sách hiệu quả trong thời đại số',
                'summary' => 'Bạn đang đọc sách nhưng không nhớ được nhiều nội dung? Dưới đây là một số phương pháp đọc sách hiệu quả giúp bạn ghi nhớ tốt hơn...',
                'author' => 'Phạm Quốc Trung',
                'category' => 'kien-thuc',
                'image' => 'images/news-page/phuong-phap-doc-sach-hieu-qua-thoi-dai-so.jpg',
                'published_date' => '2024-09-28',
                'views' => 1800
            ],
            4 => [
                'id' => 4,
                'title' => 'Văn hóa đọc ở Việt Nam: Thách thức và cơ hội',
                'summary' => 'Văn hóa đọc là một phần quan trọng trong phát triển xã hội. Bài viết phân tích thực trạng và đề xuất giải pháp phát triển văn hóa đọc...',
                'author' => 'Lê Thị Bích Ngọc',
                'category' => 'van-hoa',
                'image' => 'images/news-page/van-hoa-doc-vietnam.jpg',
                'published_date' => '2024-09-20',
                'views' => 1500
            ],
            5 => [
                'id' => 5,
                'title' => 'Sách và vai trò trong giáo dục hiện đại',
                'summary' => 'Trong thời đại công nghệ phát triển, sách vẫn giữ vai trò quan trọng trong quá trình giáo dục và phát triển tư duy...',
                'author' => 'Hoàng Văn Cường',
                'category' => 'giao-duc',
                'image' => 'images/news-page/sach-va-vai-tro-trong-giao-duc-hien-dai.jpg',
                'published_date' => '2024-09-15',
                'views' => 1300
            ],
            6 => [
                'id' => 6,
                'title' => 'Xu hướng xuất bản sách điện tử năm 2024',
                'summary' => 'Sách điện tử ngày càng phát triển và trở thành xu hướng trong ngành xuất bản hiện đại...',
                'author' => 'Nguyễn Thị Mai',
                'category' => 'cong-nghe',
                'image' => 'images/news-page/xu-huong-xuat-ban-sach-dien-tu-nam-2024.jpg',
                'published_date' => '2024-08-25',
                'views' => 1100
            ]
        ];

        $related = [];
        foreach ($allArticles as $article) {
            if ($article['category'] === $category && $article['id'] !== $currentId) {
                $related[] = $article;
                if (count($related) >= $limit) {
                    break;
                }
            }
        }

        return $related;
    }
}