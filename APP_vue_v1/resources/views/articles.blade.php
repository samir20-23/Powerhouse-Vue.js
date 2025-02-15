<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Article Manager Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --success-color: #4cc9f0;
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transform-style: preserve-3d;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .card:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem;
        }

        .card-body {
            padding: 2rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.8rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
            border-color: var(--primary-color);
        }

        .btn {
            border-radius: 10px;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::after {
            width: 300px;
            height: 300px;
        }

        .btn-success {
            background: linear-gradient(45deg, #4cc9f0, #4895ef);
            border: none;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
        }

        .btn-danger {
            background: linear-gradient(45deg, #ef476f, #ff6b6b);
            border: none;
        }

        .star-rating {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .star-rating label {
            font-size: 1.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .star-rating label:hover {
            transform: scale(1.2);
            color: #ffd700;
        }

        .star-rating input:checked~label {
            color: #ffd700;
            animation: starPulse 0.5s ease-out;
        }

        @keyframes starPulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }

            100% {
                transform: scale(1);
            }
        }

        .modal-content {
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            border: none;
        }

        .modal-header {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: none;
            padding: 1.5rem;
        }

        /* Loading animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0; 
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid var(--primary-color);
            border-top: 5px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            opacity: 0.2;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }

        /* Article cards animations */
        .article-card-enter {
            animation: cardEnter 0.5s ease-out;
        }

        @keyframes cardEnter {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Button hover effects */
        .btn-float {
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .btn-float:hover {
            transform: translateY(-3px);
        }

        /* Card content fade in */
        .card-content {
            opacity: 0;
            animation: fadeIn 0.5s ease-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-newspaper me-2"></i>
                Article Manager Pro
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <!-- Add Article Form -->
        <div class="card animate__animated animate__fadeInDown mb-5">
            <div class="card-header">
                <h4><i class="fas fa-plus-circle me-2"></i>Create New Article</h4>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label">Title</label>
                    <input type="text" id="title" class="form-control" placeholder="Enter article title...">
                </div>
                <div class="mb-4">
                    <label class="form-label">Content</label>
                    <textarea id="body" class="form-control" rows="4" placeholder="Write your article content..."></textarea>
                </div>
                <button id="add-article" class="btn btn-success btn-float">
                    <i class="fas fa-paper-plane me-2"></i>Publish Article
                </button>
            </div>
        </div>

        <!-- Articles List -->
        <div id="articles-list" class="row g-4">
            <!-- Articles will be loaded here dynamically -->
        </div>
    </div>

    <!-- Edit Article Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animate__animated animate__fadeIn">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Article
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label">Title</label>
                        <input type="text" id="edit-title" class="form-control">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Content</label>
                        <textarea id="edit-body" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" id="save-edit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Show Article Modal -->
    <div class="modal fade" id="showModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animate__animated animate__fadeIn">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-book-open me-2"></i>Article Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h4 id="show-title" class="mb-4"></h4>
                    <p id="show-body" class="mb-4"></p>
                    <div class="star-rating" id="show-rating-container"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            let currentEditArticleId = null;

            // Hide loading overlay when page is ready
            $('#loadingOverlay').fadeOut();

            function loadArticles() {
                $('#loadingOverlay').fadeIn();
                $.getJSON('/articles', function(articles) {
                    let articlesHtml = '';
                    $.each(articles, function(index, article) {
                        articlesHtml += `
                            <div class="col-md-4 article-card-enter">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">${article.title}</h5>
                                        <p class="card-text mb-4">${article.body}</p>
                                        <div class="star-rating mb-4" data-id="${article.id}">
                                            ${[...Array(6)].map((_, i) => {
                                                let checked = parseInt(article.rating, 10) > i ? 'checked' : '';
                                                return `
                                                        <input type="radio" name="rating-${article.id}" 
                                                               id="star-${article.id}-${i+1}" 
                                                               value="${i+1}" ${checked} 
                                                               data-id="${article.id}" 
                                                               class="star-input">
                                                        <label for="star-${article.id}-${i+1}">★</label>`;
                                            }).join('')}
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-success btn-sm btn-float show-article" data-id="${article.id}">
                                                <i class="fas fa-eye me-1"></i> View
                                            </button>
                                            <button class="btn btn-primary btn-sm btn-float edit-article" data-id="${article.id}">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm btn-float delete-article" data-id="${article.id}">
                                                <i class="fas fa-trash me-1"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    $('#articles-list').html(articlesHtml);
                    $('#loadingOverlay').fadeOut();
                });
            }

            loadArticles();

            // Add Article
            $('#add-article').click(function() {
                let title = $('#title').val();
                let body = $('#body').val();

                if (!title || !body) {
                    alert('Please fill in all fields');
                    return;
                }

                $('#loadingOverlay').fadeIn();
                $.ajax({
                    url: '/articles',
                    type: 'POST',
                    data: {
                        title: title,
                        body: body,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        $('#title').val('');
                        $('#body').val('');
                        loadArticles();
                        // Show success notification
                        showNotification('Article successfully created!', 'success');
                    },
                    error: function() {
                        showNotification('Error creating article', 'error');
                    },
                    complete: function() {
                        $('#loadingOverlay').fadeOut();
                    }
                });
            });

            // Update star rating
            $(document).on('click', '.star-input', function() {
                let rating = $(this).val();
                let articleId = $(this).data('id');
                $('#loadingOverlay').fadeIn();

                // Animate stars
                let stars = $(this).closest('.star-rating').find('label');
                stars.each(function(index) {
                    let star = $(this);
                    setTimeout(function() {
                        star.css('color', index < rating ? '#ffd700' : '#ccc')
                            .addClass('animate__animated animate__bounceIn');
                    }, index * 100);
                });

                $.ajax({
                    url: `/articles/${articleId}`,
                    type: 'PUT',
                    data: {
                        rating: rating,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        showNotification('Rating updated!', 'success');
                        loadArticles();
                    },
                    error: function() {
                        showNotification('Error updating rating', 'error');
                    },
                    complete: function() {
                        $('#loadingOverlay').fadeOut();
                    }
                });
            });

            // Delete Article
            $(document).on('click', '.delete-article', function() {
                let card = $(this).closest('.card');
                card.addClass('animate__animated animate__fadeOutRight');

                if (confirm('Are you sure you want to delete this article?')) {
                    let articleId = $(this).data('id');
                    $('#loadingOverlay').fadeIn();

                    $.ajax({
                        url: `/articles/${articleId}`,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            showNotification('Article deleted successfully!', 'success');
                            loadArticles();
                        },
                        error: function() {
                            showNotification('Error deleting article', 'error');
                        },
                        complete: function() {
                            $('#loadingOverlay').fadeOut();
                        }
                    });
                }
            });

            // Show Article Details
            $(document).on('click', '.show-article', function() {
                let articleId = $(this).data('id');
                $('#loadingOverlay').fadeIn();

                $.get(`/articles/${articleId}`, function(article) {
                        $('#show-title').text(article.title)
                            .addClass('animate__animated animate__fadeInDown');
                        $('#show-body').text(article.body)
                            .addClass('animate__animated animate__fadeInUp');

                        let starHtml = '';
                        for (let i = 1; i <= 6; i++) {
                            starHtml += `<span class="animate__animated animate__zoomIn" 
                                         style="animation-delay: ${i * 100}ms; 
                                                color: ${i <= article.rating ? '#ffd700' : '#ccc'}; 
                                                font-size: 1.5rem;">★</span>`;
                        }
                        $('#show-rating-container').html(starHtml);

                        let showModal = new bootstrap.Modal(document.getElementById('showModal'));
                        showModal.show();
                    })
                    .always(function() {
                        $('#loadingOverlay').fadeOut();
                    });
            });

            // Edit Article
            $(document).on('click', '.edit-article', function() {
                currentEditArticleId = $(this).data('id');
                $('#loadingOverlay').fadeIn();

                $.get(`/articles/${currentEditArticleId}`, function(article) {
                        $('#edit-title').val(article.title);
                        $('#edit-body').val(article.body);
                        let editModal = new bootstrap.Modal(document.getElementById('editModal'));
                        editModal.show();
                    })
                    .always(function() {
                        $('#loadingOverlay').fadeOut();
                    });
            });

            // Save Edit
            $('#save-edit').click(function() {
                let updatedTitle = $('#edit-title').val();
                let updatedBody = $('#edit-body').val();

                if (!updatedTitle || !updatedBody) {
                    showNotification('Please fill in all fields', 'error');
                    return;
                }

                $('#loadingOverlay').fadeIn();
                $.ajax({
                    url: `/articles/${currentEditArticleId}`,
                    type: 'PUT',
                    data: {
                        title: updatedTitle,
                        body: updatedBody,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        let modalEl = document.getElementById('editModal');
                        let modalInstance = bootstrap.Modal.getInstance(modalEl);
                        modalInstance.hide();
                        showNotification('Article updated successfully!', 'success');
                        loadArticles();
                    },
                    error: function() {
                        showNotification('Error updating article', 'error');
                    },
                    complete: function() {
                        $('#loadingOverlay').fadeOut();
                    }
                });
            });

            // Notification system
            function showNotification(message, type) {
                const notification = $(`
                    <div class="notification animate__animated animate__fadeInRight ${type}">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                        ${message}
                    </div>
                `).appendTo('body');

                setTimeout(() => {
                    notification.removeClass('animate__fadeInRight')
                        .addClass('animate__fadeOutRight');
                    setTimeout(() => notification.remove(), 1000);
                }, 3000);
            }

            // Add notification styles
            $('<style>')
                .text(`
                    .notification {
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        padding: 15px 25px;
                        border-radius: 10px;
                        color: white;
                        font-weight: 500;
                        z-index: 9999;
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                    }
                    .notification.success {
                        background: linear-gradient(45deg, #28a745, #20c997);
                    }
                    .notification.error {
                        background: linear-gradient(45deg, #dc3545, #f72585);
                    }
                    .notification i {
                        font-size: 1.25rem;
                    }
                `)
                .appendTo('head');
        });
    </script>
</body>

</html>
