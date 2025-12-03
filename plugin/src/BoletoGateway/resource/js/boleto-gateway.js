import { registerPaymentMethod } from '@woocommerce/blocks-registry';
import { decodeEntities } from '@wordpress/html-entities';
import { getSetting } from '@woocommerce/settings';

const settings = getSetting( 'boleto_data', {} );

const defaultLabel = 'Boleto Gateway'

const label = decodeEntities( settings.title ) || defaultLabel;

const Content = () => {
	return decodeEntities( settings.description || '' );
};

const Label = ( props ) => {
	const { PaymentMethodLabel } = props.components;
	return <PaymentMethodLabel text={ label } />;
};

const Boleto = {
	name: "boleto_gateway",
	label: <Label />,
	content: <Content />,
	edit: <Content />,
	canMakePayment: () => true,
	ariaLabel: label
};

registerPaymentMethod( Boleto );
