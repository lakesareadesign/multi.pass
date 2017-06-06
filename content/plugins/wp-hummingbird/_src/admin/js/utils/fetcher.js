import assign from 'lodash/assign';

function Fetcher() {
    let fetchUrl = ajaxurl;
    let fetchNonce = wphb.nonces.HBFetchNonce;
    const actionPrefix = 'wphb_pro_';

    function request( action, data = {}, method = 'GET' ) {
        data.nonce = fetchNonce;
        data.action = action;
        let args = { data, method };
        args.url = fetchUrl;
        return new Promise( ( resolve, reject ) => {
            jQuery.ajax( args ).done( resolve ).fail( reject );
        })
            .then( ( response ) => checkStatus( response ) );

    }

    const methods = {
        performance: {
            /**
             * Add a single email/name recipient to the reports list
             *
             * @param email
             * @param name
             */
            addRecipient: ( email, name ) => {
                const action = actionPrefix + 'performance_add_recipient';
                return request( action, { email, name }, 'POST' )
                    .then( ( response ) => {
                        return response;
                    } )

            },

            saveReportsSettings: ( data ) => {
                const action = actionPrefix + 'performance_save_reports_settings';
                return request( action, { data }, 'POST' );
            }
        }
    };

    assign( this, methods );
}

const HBFetcher = new Fetcher();
export default HBFetcher;

function checkStatus( response ) {
    if ( typeof response !== 'object' ) {
        response = JSON.parse( response );
    }
    if ( response.success ) {
        return response.data;
    }


    let data = response.data || {};
    const error = new Error( data.message || 'Error trying to fetch response from server' );
    error.response = response;
    throw error;
}