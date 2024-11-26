<?php  
require_once("../db_camera_connect.php");  
?>  
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <title>相簿</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS v5.2.1 -->
    <link 
        rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"/>
    <!-- Font Awesome CSS v6.6.0 -->
    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .alpha {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #6666;
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }
        .whiteboard {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 10px #3338;
        }
        .card.selected {
            outline: 2px solid #007bff;
        }
    </style>

    
</head>
<body>
    <button class="pop btn btn-dark" onclick="openModal()" title="選擇圖片!">
    選擇圖片
    </button>
    <!-- Popup -->
    <div id="modal" class="alpha">
        <div class="whiteboard">
            <?php include("album.php"); ?>
        </div>
    </div>
    <script>
        function openModal() {
            const modal = document.getElementById("modal");
            modal.style.display = "flex";
        }
        function closeModal() {
            const modal = document.getElementById("modal");
            modal.style.display = "none";
        }        
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery -->

       <script>
        $(document).ready(function() {
            // 處理搜尋表單提交
            let currentSearchQuery = '';
            $('#searchForm').off('submit').on('submit', function(e) {
                e.preventDefault();
              
                currentSearchQuery = $('input[name="search"]').val().trim();

                if (!currentSearchQuery) {
                    alert('請輸入搜尋內容！');
                    return;
                }
                loadContent(1, currentSearchQuery);
            });

            // 處理分頁連結點擊
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                loadContent(page, currentSearchQuery);
            });

            // 使用事件委派處理卡片點擊事件
            $(document).on('click', '.card', function() {
                // 移除其他卡片的選取狀態
                $('.card').removeClass('selected');
                // 為當前點擊的卡片添加選取狀態
                $(this).addClass('selected');
            });

            // 相片選擇
            $('#selectButton').on('click', function() {
                const selectedCard = $('.card.selected');
                if (selectedCard.length) {
                    const imageUrl = selectedCard.find('img').attr('src');
                    // 將 imageUrl 傳遞給主頁面，這裡可以使用事件或直接操作主頁面的 DOM
                    console.log('選取的圖片 URL:', imageUrl);
                    // 關閉模態框
                    closeModal();
                } else {
                    alert('請先選取一張圖片。');
                }
            });

            // 加載內容的函數
            function loadContent(page, searchQuery) {
                $.ajax({
                    url: 'album.php',
                    type: 'GET',
                    data: {
                        page: page,
                        search: searchQuery
                    },
                    success: function(response) {
                        $('#imageContainer').html($(response).find('#imageContainer').html());
                        $('.pagination').html($(response).find('.pagination').html());

                        $('input[name="search"]').val(searchValue);
                        // 重新初始化事件綁定
                        reinitializeEvents();
                    },
                    error: function(xhr, status, error) {
                        alert('資料載入失敗');
                    }
                });
            }

            // 重新初始化事件綁定的函數
            function reinitializeEvents() {
                // 重新綁定卡片點擊事件
                $(document).on('click', '.card', function() {
                    $('.card').removeClass('selected');
                    $(this).addClass('selected');
                });

                // 重新綁定相片選擇按鈕事件
                $('#selectButton').off('click').on('click', function () {
                    const selectedCard = $('.card.selected');
                    if (selectedCard.length) {
                        const imageUrl = selectedCard.find('img').attr('src');
                        console.log('選取的圖片 URL:', imageUrl);
                        closeModal();
                    } else {
                        alert('請先選取一張圖片。');
                    }
                });
            }
        });
    </script>
</body>
</html>