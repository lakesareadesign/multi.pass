<?php

abstract class Smartcrawl_Type_Traverser {
	public function traverse() {
		$resolver = $this->get_resolver();
		$location = $resolver->get_location();

		switch ( $location ) {
			case Smartcrawl_Endpoint_Resolver::L_BP_GROUPS:
				$this->handle_bp_groups();
				break;

			case Smartcrawl_Endpoint_Resolver::L_BP_PROFILE:
				$this->handle_bp_profile();
				break;

			case Smartcrawl_Endpoint_Resolver::L_WOO_SHOP:
				$this->handle_woo_shop();
				break;

			case Smartcrawl_Endpoint_Resolver::L_BLOG_HOME:
				$this->handle_blog_home();
				break;

			case Smartcrawl_Endpoint_Resolver::L_STATIC_HOME:
				$this->handle_static_home();
				break;

			case Smartcrawl_Endpoint_Resolver::L_SEARCH:
				$this->handle_search();
				break;

			case Smartcrawl_Endpoint_Resolver::L_404:
				$this->handle_404();
				break;

			case Smartcrawl_Endpoint_Resolver::L_DATE_ARCHIVE:
				$this->handle_date_archive();
				break;

			case Smartcrawl_Endpoint_Resolver::L_PT_ARCHIVE:
				$this->handle_pt_archive();
				break;

			case Smartcrawl_Endpoint_Resolver::L_TAX_ARCHIVE:
				$this->handle_tax_archive();
				break;

			case Smartcrawl_Endpoint_Resolver::L_AUTHOR_ARCHIVE:
				$this->handle_author_archive();
				break;

			case Smartcrawl_Endpoint_Resolver::L_ARCHIVE:
				$this->handle_archive();
				break;

			case Smartcrawl_Endpoint_Resolver::L_SINGULAR:
				$this->handle_singular();
				break;
		}
	}

	private function get_resolver() {
		return Smartcrawl_Endpoint_Resolver::resolve();
	}

	abstract public function handle_bp_groups();

	abstract public function handle_bp_profile();

	abstract public function handle_woo_shop();

	abstract public function handle_blog_home();

	abstract public function handle_static_home();

	abstract public function handle_search();

	abstract public function handle_404();

	abstract public function handle_date_archive();

	abstract public function handle_pt_archive();

	abstract public function handle_tax_archive();

	abstract public function handle_author_archive();

	abstract public function handle_archive();

	abstract public function handle_singular();
}