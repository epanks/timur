<template>
    <ul class="sidebar navbar-nav">
        <li class="nav-item">
            <router-link to="/" class="nav-link" exact>
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/categories" class="nav-link" exact>
                <i class="fas fa-fw fa-building"></i>
                <span>Categories</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/balai" class="nav-link" exact>
                <i class="fas fa-fw fa-building"></i>
                <span>Balai</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/paket" class="nav-link" exact>
                <i class="fas fa-fw fa-building"></i>
                <span>Paket</span>
            </router-link>
        </li>
    </ul>
</template>
