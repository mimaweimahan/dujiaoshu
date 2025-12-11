<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div>
             
        </div>
        <div class="card">

            <div class="card-body">
                <div class="card-title">
                    <a href="/article">首页</a>-><a href="/article?cat_id=<?php echo e($article['category_id'], false); ?>"><?php echo e($article['category']['category_name'], false); ?></a>-> <?php echo e($article['title'], false); ?>

                </div>
                <hr>
                <div class="blog-content">
                    <div class="blog-post">
                        <h3 class="blog-post-title text-center">
                            <?php echo e($article['title'], false); ?>

                        </h3>
                        <p class="blog-post-meta text-right">日期：<?php echo e($article['updated_at'], false); ?></p>
                        <p>
                            <?php echo $article['content']; ?>

                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="tab-content">
    <div class="tab-pane active" id="group-all">

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('hyper.layouts.article', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/amd.youtoube563.top/resources/views/kphyper/static_pages/articleDetail.blade.php ENDPATH**/ ?>