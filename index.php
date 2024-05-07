// Apply fixed amount discount on total amount after checking product quantity
add_action( 'woocommerce_cart_calculate_fees', 'custom_discount_total_amount_based_on_quantity' );
function custom_discount_total_amount_based_on_quantity() {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    // Define the product ID you want to check the quantity for
    $product_id_to_check = 3671; // Replace 123 with the actual ID of your product

    // Define the minimum quantity required for the discount
    $minimum_quantity_for_discount = 4; // Adjust as needed

    // Define the fixed discount amount
    $discount_amount = 3; // Adjust the discount amount as needed

    // Initialize the discount
    $discount = 0;

    // Get the quantity of the product in the cart
    $product_quantity_in_cart = 0;
    foreach ( WC()->cart->get_cart() as $cart_item ) {
        if ( $cart_item['product_id'] == $product_id_to_check ) {
            $product_quantity_in_cart += $cart_item['quantity'];
        }
    }

    // Check if the product quantity condition is met
    if ( $product_quantity_in_cart >= $minimum_quantity_for_discount ) {
        // Calculate the discount
        $discount = -$discount_amount;

        // Calculate the total amount after applying the discount
        $new_total = WC()->cart->subtotal + $discount;
		WC()->cart->add_fee( 'Discount', -$discount_amount );
        // Apply the discount to the cart total
        WC()->cart->total = $new_total;
    }
}
