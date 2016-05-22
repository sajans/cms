<!-- Page Content -->
<div class="container">

    <!-- Heading Row -->
    <div class="row">
        <div class="center">
            <h3> Sajan Sudedi</h3>
        </div>
    </div>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-md-4">
            <img class="img-responsive img-rounded" src="http://placehold.it/300x300" alt="">
        </div>
        <div class="col-md-4">
            <form id="detail-form">
                <div class="form-group row">
                    <div class="col-sm-5">
                        <label>Name</label>
                    </div>
                    <div class="col-sm-7">
                        <span class="input-sm">
                            Sajan Subedi
                        </span>
                        <?php /* ?>
                          <input type="text" name="name" disabled="disabled" value="Sajan Subedi" class="form-control input-lg">
                          <p class="help-block"></p>
                          <?php */ ?>
                    </div>
                </div>
                <?php foreach($fields as $key=>$label): ?>
                <div class="form-group row">
                    <div class="col-sm-5">
                        <label><?= $label; ?></label>
                    </div>
                    <div class="col-sm-7">
                        <span class="input-sm">
                            <?= ($this->article->detail->$key)?$this->article->detail->$key:'Null';?>
                        </span>
                    </div>

                </div>
                <?php endforeach; ?>
             
                <?php /* ?>
                  <div class="text-right">
                  <button class="btn btn-primary btn-c-2 autosave-js" data-control-area="account-settings-form" data-url="investor/profile">Save</button>
                  </div>
                  <?php */ ?>

            </form>

            <?php if (isset($current_user) && $current_user->group == 100): ?>
                <a href="<?= Uri::create('article/edit_info/' . $article->id); ?>" class="js-cms-modal-call"><i class="fa fa-pencil">Edit</i></a>
            <?php endif; ?>

        </div>
        <div class="col-md-4">
            <table class="table">
                <thead>
                    <tr>
                        <td>Born</td>
                        <td>1989</td>
                    </tr>
                    <tr>
                        <td>Awarded for national olympics champions</td>
                        <td>1989</td>
                    </tr>
                    <tr>
                        <td>marriage</td>
                        <td>1989</td>
                    </tr>
                    <tr>
                        <td>Something</td>
                        <td>1989</td>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- /.row -->

    <hr>
    <!-- Content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="well text-center">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.
                </p>


            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <!-- People Also Like -->
    <div class="related">
        <h3>You may like</h3>
        <div class="row">
            <div class="col-md-4">
                <h4>Heading 1</h4>
                <img class="img-responsive img-rounded" src="http://placehold.it/100x100" alt="">
                <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.</p>
                <a class="btn btn-default" href="#">More Info</a>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-4">
                <h4>Heading 2</h4>
                <img class="img-responsive img-rounded" src="http://placehold.it/100x100" alt="">
                <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.</p>
                <a class="btn btn-default" href="#">More Info</a>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-4">
                <h4>Heading 3</h4>
                <img class="img-responsive img-rounded" src="http://placehold.it/100x100" alt="">
                <p >Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe rem nisi accusamus error velit animi non ipsa placeat. Recusandae, suscipit, soluta quibusdam accusamus a veniam quaerat eveniet eligendi dolor consectetur.</p>
                <a class="btn btn-default" href="#">More Info</a>
            </div>
            <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->

        <!-- Footer -->

    </div>
</div>
<br>
<br>
<!-- /.container -->
<style>
    .related img{
        float:left;
        margin: 0px 14px 5px 0px;
    }
</style>