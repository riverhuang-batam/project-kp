<!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
          <!-- Sidebar scroll-->
          <div class="scroll-sidebar" data-sidebarbg="skin6">
              <!-- Sidebar navigation-->
              <nav class="sidebar-nav">
                  <ul id="sidebarnav">
                  <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{route('home')}}"
                              aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                                  class="hide-menu">Dashboard</span></a></li>
                      <li class="list-divider"></li>
                      <li class="nav-small-cap"><span class="hide-menu">Applications</span></li>

                      <li class="sidebar-item"> <a class="sidebar-link" href="{{route('suppliers.index')}}"
                              aria-expanded="false"><i data-feather="user" class="feather-icon"></i><span
                                  class="hide-menu">Supplier
                              </span></a>
                      </li>
                      <li class="sidebar-item"> <a class="sidebar-link" href="{{route('products.index')}}"
                        aria-expanded="false"><i data-feather="bookmark" class="feather-icon"></i><span
                            class="hide-menu">Product
                              </span></a>
                      </li>
                      <li class="sidebar-item"> <a class="sidebar-link" href="{{route('purchases.index')}}"
                        aria-expanded="false"><i data-feather="shopping-bag" class="feather-icon"></i><span
                            class="hide-menu">Purchase
                              </span></a>
                      </li>
                      <li class="sidebar-item"> <a class="sidebar-link" href="{{route('sales.index')}}"
                        aria-expanded="false"><i data-feather="shopping-bag" class="feather-icon"></i><span
                            class="hide-menu">Sales
                              </span></a>
                      </li>
                      {{-- <li class="sidebar-item"> <a class="sidebar-link" href="{{route('payments.index')}}"
                        aria-expanded="false"><i data-feather="credit-card" class="feather-icon"></i><span
                            class="hide-menu">Payment
                              </span></a>
                      </li> --}}
                      <li class="sidebar-item"> <a class="sidebar-link" href="{{route('akuns.index')}}"
                        aria-expanded="false"><i data-feather="credit-card" class="feather-icon"></i><span
                            class="hide-menu">Akun
                              </span></a>
                      </li>
                      <li class="sidebar-item"> <a class="sidebar-link" href="{{route('jurnals.index')}}"
                        aria-expanded="false"><i data-feather="bookmark" class="feather-icon"></i><span
                            class="hide-menu">Jurnal
                              </span></a>
                      </li>
                      <li class="nav-small-cap"><span class="hide-menu">Laporan</span></li>
                      <li class="sidebar-item"> <a class="sidebar-link" href="{{route('laba-rugi.index')}}"
                        aria-expanded="false"><i data-feather="bookmark" class="feather-icon"></i><span
                            class="hide-menu">Laba Rugi
                              </span></a>
                      </li>
                      <li class="sidebar-item"> <a class="sidebar-link" href="{{route('neraca.index')}}"
                        aria-expanded="false"><i data-feather="bar-chart-2" class="feather-icon"></i><span
                            class="hide-menu">Neraca
                              </span></a>
                      </li>
                  </ul>
              </nav>
              <!-- End Sidebar navigation -->
          </div>
          <!-- End Sidebar scroll-->
      </aside>
      <!-- ============================================================== -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->