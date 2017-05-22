function renderTrips() {
    $.ajax({
        type    : "GET",
        url     : '/v1/trips',
        data    : {'access-token': getAuchKey()},
        dataType: 'json',
        success : function (data) {
            ReactDOM.render(
                <ListTrip items={data}/>,
                document.getElementById('content')
            );
        }
    });
}

function ListTrip(props) {
    const items     = props.items;
    const listItems = items.map((item) =>
        <tr key={item.id}>
            <td><Link content={item.user} target={getTrip} href={"/v1/trips/" + item.id} /></td>
            <td>{item.organization}</td>
            <td>{item.date_start}</td>
            <td>{item.date_end}</td>

        </tr>
    );

    return (
        <div className="container">
            <table className="table">
                <thead>
                    <tr>
                        <th>user</th>
                        <th>organization</th>
                        <th>date start</th>
                        <th>date end</th>
                    </tr>
                </thead>
                <tbody>
                    {listItems}
                </tbody>
            </table>
        </div>
    );
}

function Link(props) {
    const content = props.content;
    const target  = props.target;
    const href    = props.href;

    return (
        <a href={href} onClick={target}>{content}</a>
    );
}

function getTrip($this) {
    $.ajax({
        type    : "GET",
        url     : '/v1/trips',
        data    : {'access-token': getAuchKey()},
        dataType: 'json',
        success : function (data) {
            console.log(data);
            ReactDOM.render(
                <TripForm item={data} expenses={data.expenses}/>,
                document.getElementById('content')
            );
        }
    });

    $this.preventDefault();
}

class TripForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {item: props.item};
        // const expenses = props.item.expenses | [3,5,7];
        console.log(this.state.item);
        console.log(this.state.item.expenses);
        console.log(JSON.parse(props.item.expenses));
        const expenses = [3,5,7];
        this.state.listItems = expenses.map((item) =>
            <input type="text" value={item} />
        );

        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleChange(event) {
        this.setState({value: event.target.value});
    }

    handleSubmit(event) {
        alert('A name was submitted: ' + this.state.value);
        event.preventDefault();
    }

    render() {
        return (
            <form id="trip-form" onSubmit={this.handleSubmit}>
                <label>
                    Name:
                    <input type="text" value={this.state.item.user} onChange={this.handleChange} />
                    {this.state.listItems}
                </label>
                <input type="submit" value="Submit" />
            </form>
        );
    }
}