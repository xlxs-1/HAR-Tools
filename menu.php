<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">ProjectWEB</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <?php if (!isset($_SESSION["email"])):?>
          <a class="nav-link active" aria-current="page" href="/">Home</a>
          <a class="nav-link" href="/login/">Log In</a>
          <a class="nav-link" href="/register/">Register</a>
          <?php else:?>
          <a class="nav-link" href="/account/">View Account</a>
          <a class="nav-link" href="/har-upload/">Har file uploader</a>
          <a class="nav-link" href="/visualize-data/">Visualize uploaded data</a>
          <a class="nav-link" href="/logout/">Logout</a>
          <?php endif?>
        </div>
      </div>
    </div>
          <!-- Μay implement later V login form
        <div class="container-fluid float-lg-right "><br>
          <form class="d-flex" action="" method="post" id="form1">
              <li class="list-inline-item">
                <input class="form-control me-2" type="text" id="email" name="email" placeholder="E-mail" aria-label="E-mail">
              </li>
              <li class="list-inline-item">
                <input class="form-control me-2" type="password" id="password" name="password" placeholder="Password" aria-label="Password">
              </li class="list-inline-item">
              <input type="submit" class="btn btn-success" value="Login" name="button" form="form1">
            </li>
          </form>
        </div>
      -->
  </nav>
</header>