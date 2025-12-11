<?php $__env->startSection('content'); ?>
<style>
       .avatar-sm {
        width: 30px;
        height: 30px;
        object-fit: cover;
    }
    .blog-post-meta {
        font-size: 0.875rem; /* 更新时间的字体大小 */
        color: #6c757d; /* 更新时间的字体颜色 */
    }
    .blog-post-title a {
        font-size: 1.00rem; /* 文章标题的字体大小 */
        color: inherit; /* 移除这里的蓝色颜色设置，使链接继承父元素的颜色 */
        text-decoration: none; /* 可选：移除下划线 */
    }
    .blog-post-title a:hover {
        color: #007bff; /* 当鼠标悬停时变为蓝色 */
    }
    .blog-post-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        flex-wrap: wrap;
    }
    .blog-post-header h3 {
        margin-bottom: 0; /* 移除标题的默认下边距 */
    }
    .article-summary {
        font-size: 0.775rem; /* 将摘要的字体大小调整为更小的尺寸 */
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
                <div class="card-body">
                    <nav class="nav d-flex">
                    <?php if(empty($catId)): ?>
                        <a class="p-2" href="/article"><strong>全部</strong></a>
                    <?php else: ?>
                        <a class="p-2 text-muted" href="/article">全部</a>
                    <?php endif; ?>

                    <?php $__currentLoopData = $categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($category['id'] == $catId): ?>
                            <a class="p-2" href="?cat_id=<?php echo e($category['id'], false); ?>"><strong><?php echo e($category['category_name'], false); ?></strong></a>
                        <?php else: ?>
                            <a class="p-2 text-muted" href="?cat_id=<?php echo e($category['id'], false); ?>"><?php echo e($category['category_name'], false); ?></a>
                        <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </nav>
                    <hr>
                    <div class="blog-content">
                        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="blog-post-header">
                                    <h3 class="blog-post-title">
                                        <a href="article/<?php echo e(!empty($article['link']) ? $article['link'] : $article['id'], false); ?>">
                                            <img src="<?php echo e(picture_ulr($article['picture']), false); ?>" class="avatar-sm mr-2"><?php echo e($article['title'], false); ?>

                                        </a>
                                    </h3>
                          <p class="blog-post-meta">
                          <a href="article/<?php echo e(!empty($article['link']) ? $article['link'] : $article['id'], false); ?>" class="blog-post-meta">
                                         <?php echo e($article['updated_at'], false); ?>

                                      </a>
                                </p>

                                </div>
                                <p class="article-summary"><?php echo e(\Illuminate\Support\Str::limit(strip_tags($article['content']), 100, '...'), false); ?></p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="pagination justify-content-center">
                            <?php echo e($articles->appends(request()->all())->links('vendor.pagination.default'), false); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('hyper.layouts.article', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/amd.youtoube563.top/resources/views/kphyper/static_pages/article.blade.php ENDPATH**/ ?>