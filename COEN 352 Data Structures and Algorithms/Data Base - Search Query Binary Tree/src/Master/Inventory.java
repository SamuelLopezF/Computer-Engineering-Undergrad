package Master;

public class Inventory implements Comparable<Inventory>{
    private static float total_inventory_value;
    /**
     * Data Members
     */
    String inventory_id;
    String name;
    String description;
    float unit_price;
    int quantity;
    float inventory_value;
    int reorder_level;
    int reorder_time_in_days;
    int reorder_quantity;
    String discontinued;

    public String getInventory_id() {
        return inventory_id;
    }

    public void setInventory_id(String inventory_id) {
        this.inventory_id = inventory_id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public float getUnit_price() {
        return unit_price;
    }

    public void setUnit_price(float unit_price) {
        this.unit_price = unit_price;
    }

    public int getQuantity() {
        return quantity;
    }

    public void setQuantity(int quantity) {
        this.quantity = quantity;
    }

    public float getInventory_value() {
        return inventory_value;
    }

    public void setInventory_value(float inventory_value) {
        this.inventory_value = inventory_value;
    }

    public int getReorder_level() {
        return reorder_level;
    }

    public void setReorder_level(int reorder_level) {
        this.reorder_level = reorder_level;
    }

    public int getReorder_time_in_days() {
        return reorder_time_in_days;
    }

    public void setReorder_time_in_days(int reorder_time_in_days) {
        this.reorder_time_in_days = reorder_time_in_days;
    }

    public int getReorder_quantity() {
        return reorder_quantity;
    }

    public void setReorder_quantity(int reorder_quantity) {
        this.reorder_quantity = reorder_quantity;
    }

    public String getDiscontinued() {
        return discontinued;
    }

    public void setDiscontinued(String discontinued) {
        this.discontinued = discontinued;
    }

    public static float get_total_value() {

        return total_inventory_value;
    }

    public Inventory(String name, int quantity, float unit_price ){
        this.inventory_id = "";
        this.name = name;
        this.description = "";
        this.unit_price = unit_price;
        this.quantity = quantity;
        this.inventory_value = quantity*unit_price;
        this.reorder_level = 0;
        this.reorder_time_in_days =0;
        this.reorder_quantity = 0;
        this.discontinued = "false";
    }

    public Inventory(String[] words) {
        this.inventory_id = words[0];
        this.name = words[1];
        this.description = words[2];
        this.unit_price = Float.parseFloat(words[3]);
        this.quantity = Integer.parseInt(words[4]);
        this.inventory_value = Float.parseFloat(words[5]);
        this.reorder_level = Integer.parseInt(words[6]);
        this.reorder_time_in_days = Integer.parseInt(words[7]);
        this.reorder_quantity = Integer.parseInt(words[8]);
        if (words.length == 10) {
            this.discontinued = words[9];
        }else{
            discontinued = "false";
        }
    }


    public String getKey() {
        return inventory_id;
    }


    @Override
    public String toString()
        {
            StringBuffer out = new StringBuffer();
            out.append(" VALUE ->  <");
            out.append(name).append(", ").append(description).append(", ");
            out.append(unit_price).append(", ").append(quantity).append(", ");
            out.append(inventory_value).append(", ").append(reorder_level).append(", ");
            out.append(reorder_time_in_days).append(", ").append(reorder_quantity).append(", ");
            out.append(discontinued).append(">\n");
            return out.toString();
        }

    @Override
    public int compareTo(Inventory o) {
        return 0;
    }
}





