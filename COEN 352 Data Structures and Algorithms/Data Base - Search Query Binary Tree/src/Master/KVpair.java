package Master;

public class KVpair<Integer , E extends Comparable<E>> implements Comparable<KVpair<Integer, E>>{

        int position;
        E  value;

        KVpair(int position, E e)
        {
            this.position = position;
            this.value = e;
        }


    public int getPosition() {
        return position;
    }

    public void setPosition(int position) {
        this.position = position;
    }

    public E getValue() {
        return value;
    }

    public void setValue(E value) {
        this.value = value;
    }

    @Override
    public String toString() {
        return "position = " + position +
                ", value = " + value + "\n";
    }

    @Override
    public int compareTo(KVpair<Integer,E> o) {
        if((this.getValue().compareTo((E) o.getValue())) > 0)
        {
            return 1;
        }else if((this.getValue().compareTo((E) o.getValue() ))< 0)
        {
            return -1;
        }else{
            return 0;
        }
    }
}

